export default {

    // ✅ Dashboard
    dashboard: route('dashboard'),

    // ✅ Users Module
    users: {
        index: route('admin.users.index'),
        create: route('admin.users.create'),
        store: route('admin.users.store'),
        edit: (id) => route('admin.users.edit', id),
        update: (id) => route('admin.users.update', id),
        delete: (id) => route('admin.users.destroy', id),
    },


    // ✅ Roles Module
    roles: {
        index: '/admin-settings/roles',
        create: '/admin-settings/roles/create',
        store: '/admin-settings/roles',
        edit: (id) => `/admin-settings/roles/${id}/edit`,
        update: (id) => `/admin-settings/roles/${id}`,
        delete: (id) => `/admin-settings/roles/${id}`,
    },

    // ✅ Logs
    logs: {
        index: route('admin.logs.index'),
    },

    // ✅ Common fields
    common: {
        departments: route('common.departments.index'),
        buildings: route('common.buildings.index'),
        floors: route('common.floors.index'),
        locationTypes: route('common.locationTypes.index'),
        locations: route('common.locations.index'),
    }
};
