<template>
<div class="deznav">
            <div class="deznav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="menu-title" data-i18n="YOUR COMPANY">Dummy Template</li>
          
                   <!-- Dashboard -->
    <li>

                       

         <a :href="AppRoutes.dashboard" aria-expanded="false">
            <div class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#90959F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard">
                    <rect x="3" y="3" width="7" height="9" rx="1" />
                    <rect x="14" y="3" width="7" height="5" rx="1" />
                    <rect x="14" y="12" width="7" height="9" rx="1" />
                    <rect x="3" y="16" width="7" height="5" rx="1" />
                </svg>
            </div>
            <span class="nav-text" data-i18n="Dashboard">Dashboard</span>
        </a>
    </li>

    <!-- CRM -->
    <li>
        <a href="#" aria-expanded="false">
            <div class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#90959F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users">
                    <path d="M17 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M7 21v-2a4 4 0 0 1 3-3.87" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <span class="nav-text" >CRM</span>
        </a>
    </li>

    <!-- Analytics -->
    <li>
        <a href="#" aria-expanded="false">
            <div class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#90959F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bar-chart-3">
                    <path d="M3 3v18h18" />
                    <rect x="7" y="10" width="3" height="8" />
                    <rect x="12" y="6" width="3" height="12" />
                    <rect x="17" y="3" width="3" height="15" />
                </svg>
            </div>
            <span class="nav-text" data-i18n="Analytics">Analytics</span>
        </a>
    </li>

    <!-- Sales -->
    <li>
        <a href="#" aria-expanded="false">
            <div class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#90959F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag">
                    <path d="M6 2l1 7h10l1-7" />
                    <path d="M5 9h14l-1 13H6L5 9z" />
                    <path d="M9 13a3 3 0 0 0 6 0" />
                </svg>
            </div>
            <span class="nav-text" data-i18n="Sales">Sales</span>
        </a>
    </li>

    <!-- Blog -->
    <li>
        <a href="#" aria-expanded="false">
            <div class="menu-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="#90959F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                </svg>
            </div>
            <span class="nav-text" data-i18n="Blog">Blog</span>
        </a>
    </li>


                    <li>
                        <a href="#" aria-expanded="false">
                            <div class="menu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0_113_177)">
										<path d="M17 4H6C4.79111 4 4 4.7 4 6V18C4 19.3 4.79111 20 6 20H18C19.2 20 20 19.3 20 18V7.20711C20 7.0745 19.9473 6.94732 19.8536 6.85355L17 4ZM17 11H7V4H17V11Z" fill="#90959F" />
										<path opacity="0.3" d="M14.5 4H12.5C12.2239 4 12 4.22386 12 4.5V8.5C12 8.77614 12.2239 9 12.5 9H14.5C14.7761 9 15 8.77614 15 8.5V4.5C15 4.22386 14.7761 4 14.5 4Z" fill="white" />
									</g>
									<defs>
										<clipPath id="clip0_113_177">
											<rect width="24" height="24" fill="white" />
										</clipPath>
									</defs>
								</svg>
                            </div>
                            <span class="nav-text" data-i18n="Tasks">Tasks</span>
                        </a>
                    </li>
                    <li>
                        <a href="project.html" aria-expanded="false">
                            <div class="menu-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0_115_172)">
										<path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M12 4.25933C12.1489 4.25921 12.3 4.29247 12.4426 4.36281C12.6398 4.46014 12.7994 4.61977 12.8967 4.81698L14.9389 8.95491L19.5054 9.61846C20.0519 9.69788 20.4306 10.2053 20.3512 10.7519C20.3196 10.9695 20.2171 11.1706 20.0596 11.3242L16.7553 14.5451L17.5353 19.0931C17.6287 19.6374 17.2631 20.1544 16.7188 20.2478C16.502 20.2849 16.279 20.2496 16.0844 20.1473L12 18V4.25933Z" fill="#4E5566" />
										<path fill-rule="evenodd" clip-rule="evenodd" d="M12 4.25933V18L7.91559 20.1473C7.42675 20.4043 6.82212 20.2163 6.56512 19.7275C6.46278 19.5328 6.42746 19.3099 6.46464 19.0931L7.24469 14.5451L3.94036 11.3242C3.54487 10.9387 3.53678 10.3055 3.92228 9.91006C4.07579 9.75258 4.27693 9.65009 4.49457 9.61846L9.06104 8.95492L11.1032 4.81699C11.2773 4.46426 11.6316 4.25961 12 4.25933Z" fill="#90959F" />
									</g>
									<defs>
										<clipPath id="clip0_115_172">
											<rect width="24" height="24" fill="white" />
										</clipPath>
									</defs>
								</svg>
                            </div>
                            <span class="nav-text" data-i18n="Projects">Projects</span>
                        </a>
                    </li>
                    <li class="menu-title" data-i18n="OUR FEATURES">Admin Setting</li>
                   <li>
                        <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
                            <div class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
										<path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
									</g>
								</svg>
                            </div>
                            <span class="nav-text" >Security</span>
                        </a>
                        <ul aria-expanded="false">
                             <li><a :href="AppRoutes.users.index">Users</a></li>
                            <li><a :href="AppRoutes.roles.index">Roles</a></li>
                            <li><a :href="AppRoutes.logs">Logs</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void(0);" aria-expanded="false">
                            <div class="menu-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="svg-main-icon">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<rect x="0" y="0" width="24" height="24"></rect>
										<path d="M18.6225,9.75 L18.75,9.75 C19.9926407,9.75 21,10.7573593 21,12 C21,13.2426407 19.9926407,14.25 18.75,14.25 L18.6854912,14.249994 C18.4911876,14.250769 18.3158978,14.366855 18.2393549,14.5454486 C18.1556809,14.7351461 18.1942911,14.948087 18.3278301,15.0846699 L18.372535,15.129375 C18.7950334,15.5514036 19.03243,16.1240792 19.03243,16.72125 C19.03243,17.3184208 18.7950334,17.8910964 18.373125,18.312535 C17.9510964,18.7350334 17.3784208,18.97243 16.78125,18.97243 C16.1840792,18.97243 15.6114036,18.7350334 15.1896699,18.3128301 L15.1505513,18.2736469 C15.008087,18.1342911 14.7951461,18.0956809 14.6054486,18.1793549 C14.426855,18.2558978 14.310769,18.4311876 14.31,18.6225 L14.31,18.75 C14.31,19.9926407 13.3026407,21 12.06,21 C10.8173593,21 9.81,19.9926407 9.81,18.75 C9.80552409,18.4999185 9.67898539,18.3229986 9.44717599,18.2361469 C9.26485393,18.1556809 9.05191298,18.1942911 8.91533009,18.3278301 L8.870625,18.372535 C8.44859642,18.7950334 7.87592081,19.03243 7.27875,19.03243 C6.68157919,19.03243 6.10890358,18.7950334 5.68746499,18.373125 C5.26496665,17.9510964 5.02757002,17.3784208 5.02757002,16.78125 C5.02757002,16.1840792 5.26496665,15.6114036 5.68716991,15.1896699 L5.72635306,15.1505513 C5.86570889,15.008087 5.90431906,14.7951461 5.82064513,14.6054486 C5.74410223,14.426855 5.56881236,14.310769 5.3775,14.31 L5.25,14.31 C4.00735931,14.31 3,13.3026407 3,12.06 C3,10.8173593 4.00735931,9.81 5.25,9.81 C5.50008154,9.80552409 5.67700139,9.67898539 5.76385306,9.44717599 C5.84431906,9.26485393 5.80570889,9.05191298 5.67216991,8.91533009 L5.62746499,8.870625 C5.20496665,8.44859642 4.96757002,7.87592081 4.96757002,7.27875 C4.96757002,6.68157919 5.20496665,6.10890358 5.626875,5.68746499 C6.04890358,5.26496665 6.62157919,5.02757002 7.21875,5.02757002 C7.81592081,5.02757002 8.38859642,5.26496665 8.81033009,5.68716991 L8.84944872,5.72635306 C8.99191298,5.86570889 9.20485393,5.90431906 9.38717599,5.82385306 L9.49484664,5.80114977 C9.65041313,5.71688974 9.7492905,5.55401473 9.75,5.3775 L9.75,5.25 C9.75,4.00735931 10.7573593,3 12,3 C13.2426407,3 14.25,4.00735931 14.25,5.25 L14.249994,5.31450877 C14.250769,5.50881236 14.366855,5.68410223 14.552824,5.76385306 C14.7351461,5.84431906 14.948087,5.80570889 15.0846699,5.67216991 L15.129375,5.62746499 C15.5514036,5.20496665 16.1240792,4.96757002 16.72125,4.96757002 C17.3184208,4.96757002 17.8910964,5.20496665 18.312535,5.626875 C18.7350334,6.04890358 18.97243,6.62157919 18.97243,7.21875 C18.97243,7.81592081 18.7350334,8.38859642 18.3128301,8.81033009 L18.2736469,8.84944872 C18.1342911,8.99191298 18.0956809,9.20485393 18.1761469,9.38717599 L18.1988502,9.49484664 C18.2831103,9.65041313 18.4459853,9.7492905 18.6225,9.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
										<path d="M12,15 C13.6568542,15 15,13.6568542 15,12 C15,10.3431458 13.6568542,9 12,9 C10.3431458,9 9,10.3431458 9,12 C9,13.6568542 10.3431458,15 12,15 Z" fill="#000000"></path>
									</g>
								</svg>
                            </div>
                            <span class="nav-text" >Common Fields</span>
                        </a>
                        <ul aria-expanded="false">
                             <li><a :href="AppRoutes.departments">Department</a></li>
                             <li><a :href="AppRoutes.buildings">Buildings</a></li>
                            <li><a :href="AppRoutes.floors">Floors</a></li>
                            <li><a :href="AppRoutes.locationTypes">Location Type</a></li>
                            <li><a :href="AppRoutes.locations">Location</a></li>
                        </ul>
                    </li>
                   
                
                </ul>
            </div>
            <div class="deznav-footer">
                <a href="#"  class="btn btn-docs btn-success w-100">
					<span>Version 1.1.1</span>
					<i class="fa-solid fa-arrow-up rotate-x"></i>
				</a>
            </div>

        </div>
</template>

<script setup>
 import AppRoutes from '@/routes';
</script>