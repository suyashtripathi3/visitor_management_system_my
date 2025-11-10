<?php

namespace App\Http\Controllers\VisitorManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Inertia\Inertia;
use Inertia\Response;
use Auth;
use Storage;

class VisitorController extends Controller
{
    /**
     * 🧭 Display the list of visitors (Inertia Page)
     */
    public function index(Request $request): Response
    {
        $query = Visitor::query()->orderByDesc('created_at');

        // 🔍 Status filter
        if ($request->filled('status')) {
            match ($request->status) {
                'checked_in' => $query->whereNotNull('checked_in_at')->whereNull('checked_out_at'),
                'checked_out' => $query->whereNotNull('checked_out_at'),
                'not_checked_in' => $query->whereNull('checked_in_at'),
                default => null,
            };
        }

        // 🔍 Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhere('badge_no', 'like', "%{$search}%");
            });
        }

        $visitors = $query->paginate(10)->withQueryString();

        return Inertia::render('VisitorManagement/Index', [
            'visitors' => $visitors,
            'filters' => $request->only(['search', 'status']),
        ]);
    }

    /**
     * 📄 Invite form page
     */
    public function create(): Response
    {
       return Inertia::render('VisitorManagement/Form');

    }

    /**
     * 💌 Invite new visitor
     */
    public function invite(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:191',
            'purpose' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        // 📷 Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('visitors', 'public');
        }

        // 🎟️ Auto-generate badge
        $data['badge_no'] = strtoupper(Str::random(6));
        $data['created_by'] = Auth::id();

        $visitor = Visitor::create($data);

        // 📧 (Optional) Email sending logic can go here
        return response()->json([
            'message' => 'Visitor invited successfully.',
            'visitor' => $visitor,
        ]);
    }

    /**
     * 🔁 Re-invite existing visitor
     */
    public function reinvite($id)
    {
        $visitor = Visitor::findOrFail($id);

        // Example logic for re-invitation
        // Send email again or log re-invite action
        return response()->json([
            'message' => 'Visitor re-invited successfully.',
            'visitor' => $visitor,
        ]);
    }

    /**
     * ✏️ Edit form (Not used in invite flow but kept for admin)
     */
    public function edit($id): Response
    {
        $visitor = Visitor::findOrFail($id);

        return Inertia::render('VisitorManagement/Invite', [
            'editId' => $visitor->id,
            'visitor' => $visitor,
        ]);
    }

    /**
     * 🔄 Update visitor details
     */
    public function update(Request $request, $id)
    {
        $visitor = Visitor::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'nullable|email|max:191',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:191',
            'purpose' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'badge_no' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('visitors', 'badge_no')->ignore($visitor->id),
            ],
        ]);

        if ($request->hasFile('photo')) {
            if ($visitor->photo) Storage::disk('public')->delete($visitor->photo);
            $data['photo'] = $request->file('photo')->store('visitors', 'public');
        }

        $visitor->update($data);

        return redirect()
            ->route('visitor.index')
            ->with('success', 'Visitor updated successfully.');
    }

    /**
     * 🗑️ Delete visitor
     */
    public function destroy($id)
    {
        $visitor = Visitor::findOrFail($id);
        if ($visitor->photo) Storage::disk('public')->delete($visitor->photo);
        $visitor->delete();

        return redirect()->route('visitor.index')->with('success', 'Visitor deleted successfully.');
    }

    /**
     * 🟢 Check-in visitor
     */
    public function checkIn($id)
    {
        $visitor = Visitor::findOrFail($id);

        if ($visitor->checked_in_at && !$visitor->checked_out_at) {
            return back()->with('error', 'Visitor is already checked in.');
        }

        $visitor->checked_in_at = Carbon::now();
        $visitor->checked_out_at = null;
        $visitor->save();

        return back()->with('success', 'Visitor checked in successfully.');
    }

    /**
     * 🔴 Check-out visitor
     */
    public function checkOut($id)
    {
        $visitor = Visitor::findOrFail($id);

        if (!$visitor->checked_in_at) {
            return back()->with('error', 'Visitor has not been checked in yet.');
        }

        if ($visitor->checked_out_at) {
            return back()->with('error', 'Visitor already checked out.');
        }

        $visitor->checked_out_at = Carbon::now();
        $visitor->save();

        return back()->with('success', 'Visitor checked out successfully.');
    }

    /**
     * 🔍 Smart Search for Invite Form
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['found' => false]);
        }

        $visitors = Visitor::query()
            ->where('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->orWhere('company', 'like', "%{$query}%")
            ->take(10)
            ->get();

        if ($visitors->isEmpty()) {
            return response()->json(['found' => false]);
        }

        if ($visitors->count() === 1) {
            return response()->json(['found' => true, 'visitor' => $visitors->first()]);
        }

        return response()->json(['found' => true, 'visitors' => $visitors]);
    }
}
