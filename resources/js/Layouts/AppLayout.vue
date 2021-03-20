<template>
    <div>
        <jet-banner />

        <div class="flex flex-col min-h-screen">
            <!-- Header spacer -->
            <div class="h-16"></div>

            <nav class="fixed w-full bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700 z-10">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex-shrink-0 flex items-center">
                                <inertia-link :href="route('daily-log.index')">
                                    <svg class="h-8" viewBox="0 0 142 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g class="fill-current text-gray-700 dark:text-gray-300">
                                            <path d="M37 23.2812V21.8047L38.9102 21.4766V12.418L37 12.0898V10.6016H40.9727L41.1719 12.2188L41.1953 12.4414C41.5547 11.793 41.9961 11.2852 42.5195 10.918C43.0508 10.5508 43.6562 10.3672 44.3359 10.3672C44.5781 10.3672 44.8242 10.3906 45.0742 10.4375C45.332 10.4766 45.5156 10.5156 45.625 10.5547L45.3203 12.6992L43.7148 12.6055C43.1055 12.5664 42.5938 12.707 42.1797 13.0273C41.7656 13.3398 41.4453 13.7617 41.2188 14.293V21.4766L43.1289 21.8047V23.2812H37Z" />
                                            <path d="M52.5273 23.5273C51.3555 23.5273 50.3438 23.2539 49.4922 22.707C48.6484 22.1523 47.9961 21.3906 47.5352 20.4219C47.0742 19.4453 46.8438 18.332 46.8438 17.082V16.8242C46.8438 15.5742 47.0742 14.4648 47.5352 13.4961C47.9961 12.5195 48.6484 11.7539 49.4922 11.1992C50.3438 10.6445 51.3477 10.3672 52.5039 10.3672C53.6758 10.3672 54.6836 10.6445 55.5273 11.1992C56.3789 11.7539 57.0352 12.5156 57.4961 13.4844C57.957 14.4531 58.1875 15.5664 58.1875 16.8242V17.082C58.1875 18.3398 57.957 19.457 57.4961 20.4336C57.0352 21.4023 56.3828 22.1602 55.5391 22.707C54.6953 23.2539 53.6914 23.5273 52.5273 23.5273ZM52.5273 21.7227C53.6211 21.7227 54.4531 21.2852 55.0234 20.4102C55.5938 19.5352 55.8789 18.4258 55.8789 17.082V16.8242C55.8789 15.9336 55.75 15.1406 55.4922 14.4453C55.2422 13.7422 54.8672 13.1914 54.3672 12.793C53.8672 12.3867 53.2461 12.1836 52.5039 12.1836C51.7695 12.1836 51.1523 12.3867 50.6523 12.793C50.1523 13.1914 49.7773 13.7422 49.5273 14.4453C49.2773 15.1406 49.1523 15.9336 49.1523 16.8242V17.082C49.1523 18.4258 49.4336 19.5352 49.9961 20.4102C50.5664 21.2852 51.4102 21.7227 52.5273 21.7227Z" />
                                            <path d="M66.1211 23.5273C64.9727 23.5273 63.9727 23.2617 63.1211 22.7305C62.2695 22.1914 61.6094 21.4453 61.1406 20.4922C60.6719 19.5391 60.4375 18.4375 60.4375 17.1875V16.6953C60.4375 15.4922 60.6641 14.4141 61.1172 13.4609C61.5703 12.5078 62.2227 11.7539 63.0742 11.1992C63.9258 10.6445 64.9414 10.3672 66.1211 10.3672C67.1445 10.3672 68.0391 10.5352 68.8047 10.8711C69.5781 11.207 70.2266 11.668 70.75 12.2539L70.8086 15.3008H69.0039L68.6055 13.0859C68.3398 12.8125 68.0078 12.5938 67.6094 12.4297C67.2109 12.2656 66.7422 12.1836 66.2031 12.1836C65.5156 12.1836 64.9102 12.3867 64.3867 12.793C63.8711 13.1992 63.4688 13.7422 63.1797 14.4219C62.8906 15.1016 62.7461 15.8594 62.7461 16.6953V17.1875C62.7461 18.5781 63.0469 19.6836 63.6484 20.5039C64.25 21.3164 65.0703 21.7227 66.1094 21.7227C66.8906 21.7227 67.5391 21.5078 68.0547 21.0781C68.5703 20.6484 68.8867 20.0586 69.0039 19.3086H71.0781L71.1016 19.3789C71.0625 20.1055 70.8477 20.7852 70.457 21.418C70.0664 22.0508 69.5078 22.5625 68.7812 22.9531C68.0625 23.3359 67.1758 23.5273 66.1211 23.5273Z" />
                                            <path d="M72.7891 23.2812V21.8047L74.6992 21.4766V6.81641L72.7891 6.48828V5H77.0078V16.7773L81.4961 12.3125L81.5547 12.2422L80.1953 12.0898V10.6016H85.6562V12.0898L84.0273 12.3945L80.4648 15.9805L84.8359 21.5234L86.6641 21.8047V23.2812H80.9336V21.8047L82.2227 21.6523L82.1875 21.6055L78.9766 17.4688L77.0078 19.4492V21.4766L78.918 21.8047V23.2812H72.7891Z" />
                                            <path d="M93.0742 23.5273C91.9023 23.5273 90.8828 23.2617 90.0156 22.7305C89.1484 22.1914 88.4766 21.4453 88 20.4922C87.5312 19.5391 87.2969 18.4375 87.2969 17.1875V16.6719C87.2969 15.4688 87.543 14.3945 88.0352 13.4492C88.5352 12.4961 89.1953 11.7461 90.0156 11.1992C90.8438 10.6445 91.7461 10.3672 92.7227 10.3672C94.4258 10.3672 95.7148 10.8828 96.5898 11.9141C97.4727 12.9453 97.9141 14.3203 97.9141 16.0391V17.4805H89.6875L89.6523 17.5391C89.6758 18.7578 89.9844 19.7617 90.5781 20.5508C91.1719 21.332 92.0039 21.7227 93.0742 21.7227C93.8555 21.7227 94.5391 21.6133 95.125 21.3945C95.7188 21.168 96.2305 20.8594 96.6602 20.4688L97.5625 21.9688C97.1094 22.4062 96.5078 22.7773 95.7578 23.082C95.0156 23.3789 94.1211 23.5273 93.0742 23.5273ZM89.7578 15.6758H95.6055V15.3711C95.6055 14.4648 95.3633 13.707 94.8789 13.0977C94.3945 12.4883 93.6758 12.1836 92.7227 12.1836C91.9492 12.1836 91.2891 12.5117 90.7422 13.168C90.1953 13.8164 89.8594 14.6328 89.7344 15.6172L89.7578 15.6758Z" />
                                            <path d="M104.195 23.4805C103.258 23.4805 102.512 23.207 101.957 22.6602C101.41 22.1055 101.137 21.2227 101.137 20.0117V12.3125H99.1328V10.6016H101.137V7.54297H103.445V10.6016H106.199V12.3125H103.445V20.0117C103.445 20.6211 103.566 21.0703 103.809 21.3594C104.051 21.6484 104.375 21.793 104.781 21.793C105.055 21.793 105.359 21.7695 105.695 21.7227C106.031 21.668 106.293 21.6211 106.48 21.582L106.797 23.0938C106.461 23.1953 106.047 23.2852 105.555 23.3633C105.07 23.4414 104.617 23.4805 104.195 23.4805Z" />
                                            <path d="M108.156 23.2812V21.8047L110.066 21.4766V6.81641L108.156 6.48828V5H112.375V21.4766L114.285 21.8047V23.2812H108.156Z" />
                                            <path d="M121.434 23.5273C120.262 23.5273 119.25 23.2539 118.398 22.707C117.555 22.1523 116.902 21.3906 116.441 20.4219C115.98 19.4453 115.75 18.332 115.75 17.082V16.8242C115.75 15.5742 115.98 14.4648 116.441 13.4961C116.902 12.5195 117.555 11.7539 118.398 11.1992C119.25 10.6445 120.254 10.3672 121.41 10.3672C122.582 10.3672 123.59 10.6445 124.434 11.1992C125.285 11.7539 125.941 12.5156 126.402 13.4844C126.863 14.4531 127.094 15.5664 127.094 16.8242V17.082C127.094 18.3398 126.863 19.457 126.402 20.4336C125.941 21.4023 125.289 22.1602 124.445 22.707C123.602 23.2539 122.598 23.5273 121.434 23.5273ZM121.434 21.7227C122.527 21.7227 123.359 21.2852 123.93 20.4102C124.5 19.5352 124.785 18.4258 124.785 17.082V16.8242C124.785 15.9336 124.656 15.1406 124.398 14.4453C124.148 13.7422 123.773 13.1914 123.273 12.793C122.773 12.3867 122.152 12.1836 121.41 12.1836C120.676 12.1836 120.059 12.3867 119.559 12.793C119.059 13.1914 118.684 13.7422 118.434 14.4453C118.184 15.1406 118.059 15.9336 118.059 16.8242V17.082C118.059 18.4258 118.34 19.5352 118.902 20.4102C119.473 21.2852 120.316 21.7227 121.434 21.7227Z" />
                                            <path d="M134.863 28.4023C134.254 28.4023 133.594 28.3164 132.883 28.1445C132.172 27.9805 131.547 27.7539 131.008 27.4648L131.605 25.6719C132.035 25.8984 132.543 26.0859 133.129 26.2344C133.715 26.3828 134.285 26.457 134.84 26.457C135.871 26.457 136.625 26.168 137.102 25.5898C137.586 25.0117 137.828 24.1875 137.828 23.1172V21.9102C136.984 22.9883 135.824 23.5273 134.348 23.5273C133.316 23.5273 132.426 23.2734 131.676 22.7656C130.926 22.25 130.348 21.5352 129.941 20.6211C129.543 19.6992 129.344 18.6328 129.344 17.4219V17.1758C129.344 15.8164 129.543 14.625 129.941 13.6016C130.348 12.5781 130.926 11.7852 131.676 11.2227C132.426 10.6523 133.324 10.3672 134.371 10.3672C135.941 10.3672 137.145 10.9766 137.98 12.1953L138.191 10.6016H141.707V12.0781L140.137 12.418V23.1172C140.137 24.7578 139.68 26.0469 138.766 26.9844C137.852 27.9297 136.551 28.4023 134.863 28.4023ZM134.922 21.6523C135.617 21.6523 136.199 21.4961 136.668 21.1836C137.137 20.8633 137.523 20.4141 137.828 19.8359V14C137.531 13.4609 137.145 13.0352 136.668 12.7227C136.191 12.4023 135.617 12.2422 134.945 12.2422C133.844 12.2422 133.02 12.7031 132.473 13.625C131.926 14.5469 131.652 15.7305 131.652 17.1758V17.4219C131.652 18.6953 131.922 19.7188 132.461 20.4922C133 21.2656 133.82 21.6523 134.922 21.6523Z" />
                                        </g>
                                        <g class="fill-current text-pink-500">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.92388 18.9396C8.21678 19.2325 8.21678 19.7074 7.92388 20.0003L3.35019 24.574C3.05729 24.8669 2.58242 24.8669 2.28953 24.574C1.99663 24.2811 1.99663 23.8062 2.28953 23.5133L6.86322 18.9396C7.15612 18.6467 7.63099 18.6467 7.92388 18.9396ZM13.2012 24.217C13.4941 24.5099 13.4941 24.9847 13.2012 25.2776L8.62753 29.8513C8.33464 30.1442 7.85977 30.1442 7.56687 29.8513C7.27398 29.5584 7.27398 29.0836 7.56687 28.7907L12.1406 24.217C12.4335 23.9241 12.9083 23.9241 13.2012 24.217ZM8.80344 23.3374C9.09634 23.6303 9.09634 24.1052 8.80344 24.3981L4.22974 28.9718C3.93685 29.2647 3.46198 29.2647 3.16908 28.9718C2.87619 28.6789 2.87619 28.204 3.16908 27.9111L7.74278 23.3374C8.03568 23.0445 8.51055 23.0445 8.80344 23.3374Z" />
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M31.9505 0.219684C32.133 0.402196 32.2088 0.665731 32.1512 0.917336C30.909 6.34536 28.9351 10.3893 25.3866 14.9155L24.5282 20.2737C24.5033 20.4296 24.4297 20.5737 24.318 20.6853L18.425 26.5784C18.211 26.7924 17.8893 26.8568 17.6094 26.7417C17.3295 26.6266 17.1462 26.3545 17.1447 26.0519L17.1175 20.7437C16.9129 20.8385 16.7102 20.9347 16.5095 21.0334C16.2215 21.1751 15.8752 21.1177 15.6482 20.8907L13.9795 19.222L12.5472 20.6543C12.2543 20.9472 11.7795 20.9472 11.4866 20.6543C11.1937 20.3614 11.1937 19.8865 11.4866 19.5936L12.9188 18.1614L11.2794 16.522C11.0525 16.295 10.9951 15.9487 11.1368 15.6606C11.2415 15.4476 11.3435 15.2323 11.444 15.0149L6.09017 14.9962C5.78731 14.9951 5.5148 14.812 5.39939 14.532C5.28397 14.252 5.3483 13.93 5.56247 13.7159L11.4555 7.82282C11.5671 7.7112 11.7111 7.63764 11.867 7.61263L17.3119 6.73875C21.815 3.21845 25.8477 1.25596 31.2528 0.0189169C31.5044 -0.0386662 31.768 0.0371731 31.9505 0.219684ZM15.1513 8.6047L12.3445 9.05519L7.89715 13.5025L11.9564 13.5167C12.1924 13.1423 12.4361 12.7291 12.6973 12.2863C12.7025 12.2775 12.7076 12.2687 12.7128 12.26C13.3209 11.0397 14.0597 9.80326 15.1513 8.6047ZM14.0392 12.9644C13.7818 13.4874 13.5427 14.0199 13.2977 14.5654C13.1108 14.9815 12.9206 15.405 12.7164 15.8376L13.9795 17.1007L17.1 13.9803C17.3928 13.6874 17.8677 13.6874 18.1606 13.9803C18.4535 14.2731 18.4535 14.748 18.1606 15.0409L15.0402 18.1614L16.3326 19.4538C16.7651 19.2496 17.1887 19.0593 17.6048 18.8725C18.1665 18.6202 18.7147 18.374 19.2527 18.1078C19.6096 17.897 19.9703 17.6832 20.3158 17.471C21.3251 16.8509 22.2706 16.2071 22.9509 15.5332C23.3382 15.0726 23.7171 14.6021 24.0869 14.1231C24.1157 14.0858 24.1475 14.0518 24.1817 14.0213C27.3585 9.97598 29.1986 6.38352 30.3988 1.77132C25.8097 2.96551 22.2302 4.79322 18.2096 7.94088C18.1782 7.97636 18.1431 8.00926 18.1045 8.03897C17.6056 8.42276 17.116 8.81644 16.6369 9.21925C15.9695 9.89319 15.3311 10.8319 14.7151 11.835C14.4897 12.2021 14.2626 12.5862 14.0392 12.9644ZM18.6149 20.2401L18.6354 24.2466L23.0856 19.7965L23.5246 17.0559C22.3555 18.1122 21.151 18.8356 19.961 19.4319C19.9196 19.4564 19.8785 19.4806 19.8375 19.5048C19.3982 19.7637 18.9878 20.0056 18.6149 20.2401ZM22.878 9.32153C22.5232 8.96673 21.9479 8.96673 21.5931 9.32153C21.2383 9.67632 21.2383 10.2516 21.5931 10.6064C21.9479 10.9611 22.5232 10.9611 22.878 10.6064C23.2327 10.2516 23.2327 9.67632 22.878 9.32153ZM20.5325 8.26087C21.473 7.32028 22.998 7.32028 23.9386 8.26087C24.8792 9.20145 24.8792 10.7264 23.9386 11.667C22.998 12.6076 21.4731 12.6076 20.5325 11.667C19.5919 10.7264 19.5919 9.20145 20.5325 8.26087Z" />
                                        </g>
                                    </svg>
                                </inertia-link>
                            </div>

                            <!-- Navigation Links -->
                            <!-- <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex"> -->
                            <!--     <jet-nav-link :href="route('daily-log.index')" :active="route().current('daily-log.index')"> -->
                            <!--         Daily Log -->
                            <!--     </jet-nav-link> -->
                            <!-- </div> -->
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 relative">
                                <!-- Teams Dropdown -->
                                <jet-dropdown align="right" width="60" v-if="$page.props.jetstream.hasTeamFeatures">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                                {{ $page.props.user.current_team.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="w-60">
                                            <!-- Team Management -->
                                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Manage Team
                                                </div>

                                                <!-- Team Settings -->
                                                <jet-dropdown-link :href="route('teams.show', $page.props.user.current_team)">
                                                    Team Settings
                                                </jet-dropdown-link>

                                                <jet-dropdown-link :href="route('teams.create')" v-if="$page.props.jetstream.canCreateTeams">
                                                    Create New Team
                                                </jet-dropdown-link>

                                                <div class="border-t border-gray-100"></div>

                                                <!-- Team Switcher -->
                                                <div class="block px-4 py-2 text-xs text-gray-400">
                                                    Switch Teams
                                                </div>

                                                <template v-for="team in $page.props.user.all_teams">
                                                    <form @submit.prevent="switchToTeam(team)" :key="team.id">
                                                        <jet-dropdown-link as="button">
                                                            <div class="flex items-center">
                                                                <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                                <div>{{ team.name }}</div>
                                                            </div>
                                                        </jet-dropdown-link>
                                                    </form>
                                                </template>
                                            </template>
                                        </div>
                                    </template>
                                </jet-dropdown>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <jet-dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 dark:focus:border-gray-500 transition duration-150 ease-in-out">
                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-300 bg-white dark:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-100 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400 dark:text-gray-300">
                                            Manage Account
                                        </div>

                                        <jet-dropdown-link :href="route('profile.show')">
                                            Profile
                                        </jet-dropdown-link>

                                        <jet-dropdown-link :href="route('spark.portal')" as="a">
                                            Billing
                                        </jet-dropdown-link>

                                        <jet-dropdown-link as="button" @click.native="showingSupportModal = true">
                                            Support &amp; Requests
                                        </jet-dropdown-link>

                                        <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                                            API Tokens
                                        </jet-dropdown-link>

                                        <div class="border-t border-gray-100 dark:border-gray-600"></div>

                                        <!-- Authentication -->
                                        <form method="post" action="/logout">
                                            <input type="hidden" name="_token" :value="$page.props.csrf_token" />
                                            <jet-dropdown-link as="button">
                                                Logout
                                            </jet-dropdown-link>
                                        </form>
                                    </template>
                                </jet-dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-200 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'flex': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden justify-end fixed inset-0 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 bg-opacity-75 mt-16">
                    <div class="absolute inset-0" @click="showingNavigationDropdown = false"></div>
                    <div class="w-2/3 bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700 overflow-y-auto shadow-lg z-10">
                        <!-- <div class="pt-2 pb-3 space-y-1"> -->
                        <!--     <jet-responsive-nav-link :href="route('daily-log.index')" :active="route().current('daily-log.index')"> -->
                        <!--         Daily Log -->
                        <!--     </jet-responsive-nav-link> -->
                        <!-- </div> -->
                        <!-- Responsive Settings Options -->
                        <div class="pt-4 pb-1">
                            <div class="flex items-center px-4">
                                <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3" >
                                    <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                                </div>

                                <div>
                                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ $page.props.user.name }}</div>
                                    <div class="font-medium text-sm text-gray-500">{{ $page.props.user.email }}</div>
                                </div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <jet-responsive-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                                    Profile
                                </jet-responsive-nav-link>

                                <jet-responsive-nav-link :href="route('spark.portal')" as="a">
                                    Billing
                                </jet-responsive-nav-link>

                                <jet-responsive-nav-link @click.native="showingSupportModal = true" as="button">
                                    Support &amp; Requests
                                </jet-responsive-nav-link>

                                <jet-responsive-nav-link :href="route('api-tokens.index')" :active="route().current('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">
                                    API Tokens
                                </jet-responsive-nav-link>

                                <!-- Authentication -->
                                <form method="post" action="/logout">
                                    <input type="hidden" name="_token" :value="$page.props.csrf_token" />
                                    <jet-responsive-nav-link as="button">
                                        Logout
                                    </jet-responsive-nav-link>
                                </form>

                                <!-- Team Management -->
                                <template v-if="$page.props.jetstream.hasTeamFeatures">
                                    <div class="border-t border-gray-200"></div>

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Team
                                    </div>

                                    <!-- Team Settings -->
                                    <jet-responsive-nav-link :href="route('teams.show', $page.props.user.current_team)" :active="route().current('teams.show')">
                                        Team Settings
                                    </jet-responsive-nav-link>

                                    <jet-responsive-nav-link :href="route('teams.create')" :active="route().current('teams.create')">
                                        Create New Team
                                    </jet-responsive-nav-link>

                                    <div class="border-t border-gray-200"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Switch Teams
                                    </div>

                                    <template v-for="team in $page.props.user.all_teams">
                                        <form @submit.prevent="switchToTeam(team)" :key="team.id">
                                            <jet-responsive-nav-link as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </jet-responsive-nav-link>
                                        </form>
                                    </template>
                                </template>
                            </div>

                            <div class="mt-3 border-t border-gray-200 dark:border-gray-700 p-4">
                                <index />
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <!-- <header class="bg-white shadow" v-if="$slots.header"> -->
            <!--     <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8"> -->
            <!--         <slot name="header"></slot> -->
            <!--     </div> -->
            <!-- </header> -->

            <!-- Page Content -->
            <main class="flex-1 flex flex-col">
                <slot></slot>
            </main>

            <support-modal :show="showingSupportModal" @close="showingSupportModal = false" />

            <!-- Modal Portal -->
            <portal-target name="modal" multiple>
            </portal-target>
        </div>
    </div>
</template>

<script>
    import JetBanner from '@/Jetstream/Banner'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
    import Index from '@/Components/Index'
    import SupportModal from '@/Components/SupportModal'

    export default {
        components: {
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            Index,
            SupportModal,
        },

        data() {
            return {
                showingNavigationDropdown: false,
                showingSupportModal: false,
            }
        },

        watch: {
            showingNavigationDropdown: {
                immediate: true,
                handler: (show) => {
                    if (show) {
                        document.body.style.overflow = 'hidden'
                    } else {
                        document.body.style.overflow = null
                    }
                }
            }
        },

        mounted() {
            window.addEventListener('resize', this.handleOrientationChange);
            this.$once('hook:destroyed', () => window.removeEventListener('resize', this.handleOrientationChange))
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            handleOrientationChange() {
                this.showingNavigationDropdown = false;
            }
        }
    }
</script>
