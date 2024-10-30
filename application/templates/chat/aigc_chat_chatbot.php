<?php
/*
  Name: Template By Key
 */
use MoredealAiWriter\application\Plugin;
defined( '\ABSPATH' ) || exit;
wp_enqueue_style('moredeal_manifest', Plugin::plugin_res() . '/chat/chatbot.css');
?>

<?php if ( $title ?? '' ): ?>
    <h3 class="moredeal-shortcode-title"><?php echo esc_html( $title ?? '' ); ?></h3>
<?php endif; ?>

<div>
    <h1>Chat bot</h1>
    <!-- <div id="wrap_circle" class="wrap_circle" onclick="showContent()">
        <div id="wrap_content" class="wrap_content hidden" > -->
            <div style="display: none">
                <svg>
                    <symbol viewBox="0 0 24 24" id="optionIcon">
                        <path fill="currentColor"
                            d="M12 3c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0 14c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0-7c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2z">
                        </path>
                    </symbol>
                    <symbol viewBox="0 0 24 24" id="refreshIcon">
                        <path fill="currentColor"
                            d="M18.537 19.567A9.961 9.961 0 0 1 12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10c0 2.136-.67 4.116-1.81 5.74L17 12h3a8 8 0 1 0-2.46 5.772l.997 1.795z">
                        </path>
                    </symbol>
                    <symbol viewBox="0 0 24 24" id="halfRefIcon">
                        <path fill="currentColor"
                            d="M 4.009 12.163 C 4.012 12.206 2.02 12.329 2 12.098 C 2 6.575 6.477 2 12 2 C 17.523 2 22 6.477 22 12 C 22 14.136 21.33 16.116 20.19 17.74 L 17 12 L 20 12 C 19.999 5.842 13.333 1.993 7.999 5.073 C 3.211 8.343 4.374 12.389 4.009 12.163 Z" />
                    </symbol>
                    <symbol viewBox="-2 -2 20 20" id="copyIcon">
                        <path fill="currentColor"
                            d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z">
                        </path>
                        <path fill="currentColor"
                            d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z">
                        </path>
                    </symbol>
                    <symbol viewBox="0 0 24 24" id="delIcon">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7v0a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v0M9 7h6M9 7H6m9 0h3m2 0h-2M4 7h2m0 0v11a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7">
                        </path>
                    </symbol>
                    <symbol viewBox="0 0 24 24" id="readyVoiceIcon">
                        <path fill="currentColor"
                            d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z">
                        </path>
                    </symbol>
                    <symbol viewBox="0 0 16 16" id="pauseVoiceIcon">
                        <path stroke="currentColor" stroke-width="2" d="M5 2v12M11 2v12"></path>
                    </symbol>
                    <symbol viewBox="0 0 16 16" id="resumeVoiceIcon">
                        <path fill="currentColor" d="M4 2L4 14L12 8Z"></path>
                    </symbol>
                    <symbol viewBox="0 0 24 24" id="stopResIcon">
                        <path fill="currentColor"
                            d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10zm0-2a8 8 0 1 0 0-16a8 8 0 0 0 0 16zM9 9h6v6H9V9z">
                        </path>
                    </symbol>
                    <symbol viewBox="0 0 128 128" id="downAudioIcon">
                        <path
                            d="M 64.662 1.549 C 56.549 4.524, 46.998 14.179, 45.523 20.895 C 45.041 23.089, 44.073 23.833, 40.433 24.807 C 34.752 26.326, 27.956 32.929, 25.527 39.289 C 24.273 42.574, 23.884 45.715, 24.196 50.034 C 24.620 55.897, 24.528 56.193, 21.836 57.585 C 17.142 60.012, 16 63.617, 16 76 C 16 88.463, 17.137 91.985, 21.967 94.483 C 28.244 97.729, 36.120 95.350, 38.579 89.466 C 39.387 87.532, 40 82.764, 40 78.415 C 40 70.971, 40.060 70.783, 42.250 71.370 C 43.487 71.701, 48.888 71.979, 54.250 71.986 L 64 72 64 76 L 64 80 57.122 80 C 49.420 80, 48.614 80.543, 47.547 86.453 C 46.552 91.964, 43.550 97.473, 40.273 99.803 C 33 104.974, 23.120 105.042, 16.118 99.971 C 11.407 96.558, 9.048 92.484, 8.145 86.205 C 6.963 77.979, 0.794 77.729, 0.191 85.883 C -0.196 91.111, 3.323 99.170, 8.062 103.908 C 11.290 107.136, 20.073 111.969, 22.750 111.990 C 23.540 111.996, 24 113.472, 24 116 C 24 119.740, 23.813 120, 21.122 120 C 17.674 120, 15.727 122.044, 16.173 125.195 C 16.492 127.441, 16.781 127.500, 27.391 127.500 C 36.676 127.500, 38.445 127.242, 39.386 125.750 C 40.993 123.203, 38.986 120.568, 35.149 120.187 C 32.206 119.894, 32 119.617, 32 115.956 C 32 112.509, 32.330 111.959, 34.750 111.377 C 42.181 109.591, 52.157 101.208, 53.575 95.559 C 53.928 94.152, 54.514 93, 54.878 93 C 55.242 93, 59.797 97.275, 65 102.500 C 70.762 108.286, 75.256 112, 76.495 112 C 77.769 112, 83.287 107.231, 91.264 99.236 C 101.113 89.366, 104 85.876, 104 83.843 C 104 80.580, 102.553 80, 94.418 80 L 88 80 88 76.105 L 88 72.211 99.750 71.815 C 113.117 71.364, 117.595 69.741, 122.762 63.473 C 128.159 56.925, 129.673 45.269, 126.134 37.500 C 123.787 32.346, 117.218 26.445, 112.132 24.921 C 108.617 23.868, 107.767 22.968, 105.028 17.405 C 99.364 5.901, 89.280 -0.062, 75.712 0.070 C 71.746 0.109, 66.773 0.774, 64.662 1.549 M 67.885 9.380 C 60.093 12.164, 55.057 17.704, 52.527 26.276 C 51.174 30.856, 50.220 31.617, 44.729 32.496 C 37.017 33.729, 30.917 42.446, 32.374 50.154 C 34.239 60.026, 40.582 63.944, 54.750 63.978 L 64 64 64 57.122 C 64 52.457, 64.449 49.872, 65.396 49.086 C 66.310 48.328, 70.370 48.027, 77.146 48.214 L 87.500 48.500 87.794 56.359 L 88.088 64.218 98.989 63.845 C 108.043 63.535, 110.356 63.125, 112.634 61.424 C 119.736 56.122, 121.911 47.667, 118.097 40.190 C 115.870 35.824, 110.154 32.014, 105.790 31.985 C 102.250 31.961, 101.126 30.787, 99.532 25.443 C 95.580 12.197, 80.880 4.736, 67.885 9.380 M 72 70.800 C 72 80.978, 71.625 85.975, 70.800 86.800 C 70.140 87.460, 67.781 88, 65.559 88 L 61.517 88 68.759 95.241 L 76 102.483 83.241 95.241 L 90.483 88 86.441 88 C 84.219 88, 81.860 87.460, 81.200 86.800 C 80.375 85.975, 80 80.978, 80 70.800 L 80 56 76 56 L 72 56 72 70.800 M 25.200 65.200 C 23.566 66.834, 23.566 85.166, 25.200 86.800 C 27.002 88.602, 29.798 88.246, 30.965 86.066 C 31.534 85.002, 32 80.472, 32 76 C 32 71.528, 31.534 66.998, 30.965 65.934 C 29.798 63.754, 27.002 63.398, 25.200 65.200"
                            stroke="none" fill="currentColor" fill-rule="evenodd" />
                    </symbol>
                    <symbol viewBox="0 0 24 24" id="chatIcon">
                        <path fill="currentColor"
                            d="m18 21l-1.4-1.4l1.575-1.6H14v-2h4.175L16.6 14.4L18 13l4 4l-4 4ZM3 21V6q0-.825.588-1.413T5 4h12q.825 0 1.413.588T19 6v5.075q-.25-.05-.5-.063T18 11q-.25 0-.5.013t-.5.062V6H5v10h7.075q-.05.25-.063.5T12 17q0 .25.013.5t.062.5H6l-3 3Zm4-11h8V8H7v2Zm0 4h5v-2H7v2Zm-2 2V6v10Z" />
                    </symbol>
                    <symbol viewBox="0 0 24 24" id="chatEditIcon">
                        <path fill="currentColor"
                            d="M5 19h1.4l8.625-8.625l-1.4-1.4L5 17.6V19ZM19.3 8.925l-4.25-4.2l1.4-1.4q.575-.575 1.413-.575t1.412.575l1.4 1.4q.575.575.6 1.388t-.55 1.387L19.3 8.925ZM17.85 10.4L7.25 21H3v-4.25l10.6-10.6l4.25 4.25Zm-3.525-.725l-.7-.7l1.4 1.4l-.7-.7Z">
                        </path>
                    </symbol>
                    <symbol viewBox="0 0 24 24" id="deleteIcon">
                        <path fill="currentColor"
                            d="M8 20v-5h2v5h9v-7H5v7h3zm-4-9h16V8h-6V4h-4v4H4v3zM3 21v-8H2V7a1 1 0 0 1 1-1h5V3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v3h5a1 1 0 0 1 1 1v6h-1v8a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z">
                        </path>
                    </symbol>
                    <symbol viewBox="0 0 24 24" id="addIcon" stroke="currentColor" fill="none" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </symbol>
                    <symbol viewBox="0 0 200 100" preserveAspectRatio="xMidYMid" id="loadingIcon">
                        <g transform="translate(50 50)">
                            <circle cx="0" cy="0" r="15" fill="#e15b64">
                                <animateTransform attributeName="transform" type="scale" begin="-0.3333333333333333s"
                                    calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1"
                                    dur="1s" repeatCount="indefinite"></animateTransform>
                            </circle>
                        </g>
                        <g transform="translate(100 50)">
                            <circle cx="0" cy="0" r="15" fill="#f8b26a">
                                <animateTransform attributeName="transform" type="scale" begin="-0.16666666666666666s"
                                    calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1"
                                    dur="1s" repeatCount="indefinite"></animateTransform>
                            </circle>
                        </g>
                        <g transform="translate(150 50)">
                            <circle cx="0" cy="0" r="15" fill="#99c959">
                                <animateTransform attributeName="transform" type="scale" begin="0s" calcMode="spline"
                                    keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="1s"
                                    repeatCount="indefinite"></animateTransform>
                            </circle>
                        </g>
                    </symbol>
                    <symbol viewBox="0 0 24 24" id="exportIcon">
                        <path fill="currentColor"
                            d="M4 19h16v-7h2v8a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-8h2v7zM14 9h5l-7 7l-7-7h5V3h4v6z"></path>
                    </symbol>
                    <symbol viewBox="0 0 24 24" id="importIcon">
                        <path fill="currentColor"
                            d="M4 19h16v-7h2v8a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-8h2v7zM14 9v6h-4V9H5l7-7l7 7h-5z"></path>
                    </symbol>
                    <symbol viewBox="0 0 24 24" id="clearAllIcon">
                        <path fill="currentColor"
                            d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10zm0-2a8 8 0 1 0 0-16a8 8 0 0 0 0 16zm0-9.414l2.828-2.829l1.415 1.415L13.414 12l2.829 2.828l-1.415 1.415L12 13.414l-2.828 2.829l-1.415-1.415L10.586 12L7.757 9.172l1.415-1.415L12 10.586z">
                        </path>
                    </symbol>
                </svg>
            </div>
            <div style="height: 500px; width: 100%; position: relative;">
                <div style="display: none">
                    <svg>
                        <symbol viewBox="0 0 24 24" id="optionIcon">
                            <path fill="currentColor"
                                d="M12 3c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0 14c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2zm0-7c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2z">
                            </path>
                        </symbol>
                        <symbol viewBox="0 0 24 24" id="refreshIcon">
                            <path fill="currentColor"
                                d="M18.537 19.567A9.961 9.961 0 0 1 12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10c0 2.136-.67 4.116-1.81 5.74L17 12h3a8 8 0 1 0-2.46 5.772l.997 1.795z">
                            </path>
                        </symbol>
                        <symbol viewBox="0 0 24 24" id="halfRefIcon">
                            <path fill="currentColor"
                                d="M 4.009 12.163 C 4.012 12.206 2.02 12.329 2 12.098 C 2 6.575 6.477 2 12 2 C 17.523 2 22 6.477 22 12 C 22 14.136 21.33 16.116 20.19 17.74 L 17 12 L 20 12 C 19.999 5.842 13.333 1.993 7.999 5.073 C 3.211 8.343 4.374 12.389 4.009 12.163 Z" />
                        </symbol>
                        <symbol viewBox="-2 -2 20 20" id="copyIcon">
                            <path fill="currentColor"
                                d="M0 6.75C0 5.784.784 5 1.75 5h1.5a.75.75 0 0 1 0 1.5h-1.5a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-1.5a.75.75 0 0 1 1.5 0v1.5A1.75 1.75 0 0 1 9.25 16h-7.5A1.75 1.75 0 0 1 0 14.25Z">
                            </path>
                            <path fill="currentColor"
                                d="M5 1.75C5 .784 5.784 0 6.75 0h7.5C15.216 0 16 .784 16 1.75v7.5A1.75 1.75 0 0 1 14.25 11h-7.5A1.75 1.75 0 0 1 5 9.25Zm1.75-.25a.25.25 0 0 0-.25.25v7.5c0 .138.112.25.25.25h7.5a.25.25 0 0 0 .25-.25v-7.5a.25.25 0 0 0-.25-.25Z">
                            </path>
                        </symbol>
                        <symbol viewBox="0 0 24 24" id="delIcon">
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 7v0a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v0M9 7h6M9 7H6m9 0h3m2 0h-2M4 7h2m0 0v11a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7">
                            </path>
                        </symbol>
                        <symbol viewBox="0 0 24 24" id="readyVoiceIcon">
                            <path fill="currentColor"
                                d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z">
                            </path>
                        </symbol>
                        <symbol viewBox="0 0 16 16" id="pauseVoiceIcon">
                            <path stroke="currentColor" stroke-width="2" d="M5 2v12M11 2v12"></path>
                        </symbol>
                        <symbol viewBox="0 0 16 16" id="resumeVoiceIcon">
                            <path fill="currentColor" d="M4 2L4 14L12 8Z"></path>
                        </symbol>
                        <symbol viewBox="0 0 24 24" id="stopResIcon">
                            <path fill="currentColor"
                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10zm0-2a8 8 0 1 0 0-16a8 8 0 0 0 0 16zM9 9h6v6H9V9z">
                            </path>
                        </symbol>
                        <symbol viewBox="0 0 128 128" id="downAudioIcon">
                            <path
                                d="M 64.662 1.549 C 56.549 4.524, 46.998 14.179, 45.523 20.895 C 45.041 23.089, 44.073 23.833, 40.433 24.807 C 34.752 26.326, 27.956 32.929, 25.527 39.289 C 24.273 42.574, 23.884 45.715, 24.196 50.034 C 24.620 55.897, 24.528 56.193, 21.836 57.585 C 17.142 60.012, 16 63.617, 16 76 C 16 88.463, 17.137 91.985, 21.967 94.483 C 28.244 97.729, 36.120 95.350, 38.579 89.466 C 39.387 87.532, 40 82.764, 40 78.415 C 40 70.971, 40.060 70.783, 42.250 71.370 C 43.487 71.701, 48.888 71.979, 54.250 71.986 L 64 72 64 76 L 64 80 57.122 80 C 49.420 80, 48.614 80.543, 47.547 86.453 C 46.552 91.964, 43.550 97.473, 40.273 99.803 C 33 104.974, 23.120 105.042, 16.118 99.971 C 11.407 96.558, 9.048 92.484, 8.145 86.205 C 6.963 77.979, 0.794 77.729, 0.191 85.883 C -0.196 91.111, 3.323 99.170, 8.062 103.908 C 11.290 107.136, 20.073 111.969, 22.750 111.990 C 23.540 111.996, 24 113.472, 24 116 C 24 119.740, 23.813 120, 21.122 120 C 17.674 120, 15.727 122.044, 16.173 125.195 C 16.492 127.441, 16.781 127.500, 27.391 127.500 C 36.676 127.500, 38.445 127.242, 39.386 125.750 C 40.993 123.203, 38.986 120.568, 35.149 120.187 C 32.206 119.894, 32 119.617, 32 115.956 C 32 112.509, 32.330 111.959, 34.750 111.377 C 42.181 109.591, 52.157 101.208, 53.575 95.559 C 53.928 94.152, 54.514 93, 54.878 93 C 55.242 93, 59.797 97.275, 65 102.500 C 70.762 108.286, 75.256 112, 76.495 112 C 77.769 112, 83.287 107.231, 91.264 99.236 C 101.113 89.366, 104 85.876, 104 83.843 C 104 80.580, 102.553 80, 94.418 80 L 88 80 88 76.105 L 88 72.211 99.750 71.815 C 113.117 71.364, 117.595 69.741, 122.762 63.473 C 128.159 56.925, 129.673 45.269, 126.134 37.500 C 123.787 32.346, 117.218 26.445, 112.132 24.921 C 108.617 23.868, 107.767 22.968, 105.028 17.405 C 99.364 5.901, 89.280 -0.062, 75.712 0.070 C 71.746 0.109, 66.773 0.774, 64.662 1.549 M 67.885 9.380 C 60.093 12.164, 55.057 17.704, 52.527 26.276 C 51.174 30.856, 50.220 31.617, 44.729 32.496 C 37.017 33.729, 30.917 42.446, 32.374 50.154 C 34.239 60.026, 40.582 63.944, 54.750 63.978 L 64 64 64 57.122 C 64 52.457, 64.449 49.872, 65.396 49.086 C 66.310 48.328, 70.370 48.027, 77.146 48.214 L 87.500 48.500 87.794 56.359 L 88.088 64.218 98.989 63.845 C 108.043 63.535, 110.356 63.125, 112.634 61.424 C 119.736 56.122, 121.911 47.667, 118.097 40.190 C 115.870 35.824, 110.154 32.014, 105.790 31.985 C 102.250 31.961, 101.126 30.787, 99.532 25.443 C 95.580 12.197, 80.880 4.736, 67.885 9.380 M 72 70.800 C 72 80.978, 71.625 85.975, 70.800 86.800 C 70.140 87.460, 67.781 88, 65.559 88 L 61.517 88 68.759 95.241 L 76 102.483 83.241 95.241 L 90.483 88 86.441 88 C 84.219 88, 81.860 87.460, 81.200 86.800 C 80.375 85.975, 80 80.978, 80 70.800 L 80 56 76 56 L 72 56 72 70.800 M 25.200 65.200 C 23.566 66.834, 23.566 85.166, 25.200 86.800 C 27.002 88.602, 29.798 88.246, 30.965 86.066 C 31.534 85.002, 32 80.472, 32 76 C 32 71.528, 31.534 66.998, 30.965 65.934 C 29.798 63.754, 27.002 63.398, 25.200 65.200"
                                stroke="none" fill="currentColor" fill-rule="evenodd" />
                        </symbol>
                        <symbol viewBox="0 0 24 24" id="chatIcon">
                            <path fill="currentColor"
                                d="m18 21l-1.4-1.4l1.575-1.6H14v-2h4.175L16.6 14.4L18 13l4 4l-4 4ZM3 21V6q0-.825.588-1.413T5 4h12q.825 0 1.413.588T19 6v5.075q-.25-.05-.5-.063T18 11q-.25 0-.5.013t-.5.062V6H5v10h7.075q-.05.25-.063.5T12 17q0 .25.013.5t.062.5H6l-3 3Zm4-11h8V8H7v2Zm0 4h5v-2H7v2Zm-2 2V6v10Z" />
                        </symbol>
                        <symbol viewBox="0 0 24 24" id="chatEditIcon">
                            <path fill="currentColor"
                                d="M5 19h1.4l8.625-8.625l-1.4-1.4L5 17.6V19ZM19.3 8.925l-4.25-4.2l1.4-1.4q.575-.575 1.413-.575t1.412.575l1.4 1.4q.575.575.6 1.388t-.55 1.387L19.3 8.925ZM17.85 10.4L7.25 21H3v-4.25l10.6-10.6l4.25 4.25Zm-3.525-.725l-.7-.7l1.4 1.4l-.7-.7Z">
                            </path>
                        </symbol>
                        <symbol viewBox="0 0 24 24" id="deleteIcon">
                            <path fill="currentColor"
                                d="M8 20v-5h2v5h9v-7H5v7h3zm-4-9h16V8h-6V4h-4v4H4v3zM3 21v-8H2V7a1 1 0 0 1 1-1h5V3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v3h5a1 1 0 0 1 1 1v6h-1v8a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z">
                            </path>
                        </symbol>
                        <symbol viewBox="0 0 24 24" id="addIcon" stroke="currentColor" fill="none" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </symbol>
                        <symbol viewBox="0 0 200 100" preserveAspectRatio="xMidYMid" id="loadingIcon">
                            <g transform="translate(50 50)">
                                <circle cx="0" cy="0" r="15" fill="#e15b64">
                                    <animateTransform attributeName="transform" type="scale" begin="-0.3333333333333333s"
                                        calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1"
                                        dur="1s" repeatCount="indefinite"></animateTransform>
                                </circle>
                            </g>
                            <g transform="translate(100 50)">
                                <circle cx="0" cy="0" r="15" fill="#f8b26a">
                                    <animateTransform attributeName="transform" type="scale" begin="-0.16666666666666666s"
                                        calcMode="spline" keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1"
                                        dur="1s" repeatCount="indefinite"></animateTransform>
                                </circle>
                            </g>
                            <g transform="translate(150 50)">
                                <circle cx="0" cy="0" r="15" fill="#99c959">
                                    <animateTransform attributeName="transform" type="scale" begin="0s" calcMode="spline"
                                        keySplines="0.3 0 0.7 1;0.3 0 0.7 1" values="0;1;0" keyTimes="0;0.5;1" dur="1s"
                                        repeatCount="indefinite"></animateTransform>
                                </circle>
                            </g>
                        </symbol>
                        <symbol viewBox="0 0 24 24" id="exportIcon">
                            <path fill="currentColor"
                                d="M4 19h16v-7h2v8a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-8h2v7zM14 9h5l-7 7l-7-7h5V3h4v6z"></path>
                        </symbol>
                        <symbol viewBox="0 0 24 24" id="importIcon">
                            <path fill="currentColor"
                                d="M4 19h16v-7h2v8a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-8h2v7zM14 9v6h-4V9H5l7-7l7 7h-5z"></path>
                        </symbol>
                        <symbol viewBox="0 0 24 24" id="clearAllIcon">
                            <path fill="currentColor"
                                d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10zm0-2a8 8 0 1 0 0-16a8 8 0 0 0 0 16zm0-9.414l2.828-2.829l1.415 1.415L13.414 12l2.829 2.828l-1.415 1.415L12 13.414l-2.828 2.829l-1.415-1.415L10.586 12L7.757 9.172l1.415-1.415L12 10.586z">
                            </path>
                        </symbol>
                    </svg>
                </div>
                <div id="loadMask">
                    <div>
                        <div>ChatGPT</div>
                        <svg>
                            <use xlink:href="#loadingIcon" />
                        </svg>
                    </div>
                </div>
                <div class="chat_window">
                    <div class="overlay"></div>
                    <nav class="nav">
                        <div id="newChat">
                            <svg width="24" height="24">
                                <use xlink:href="#addIcon" />
                            </svg>
                            <span>新建会话</span>
                        </div>
                        <div id="chatList"></div>
                        <div class="navFooter">
                            <div class="navFunc">
                                <div id="exportChat">
                                    <svg width="24" height="24">
                                        <use xlink:href="#exportIcon" />
                                    </svg>
                                    <span>导出</span>
                                </div>
                                <label id="importChat" for="importChatInput">
                                    <svg width="24" height="24">
                                        <use xlink:href="#importIcon" />
                                    </svg>
                                    <span>导入</span>
                                </label>
                                <input type="file" style="display: none;" id="importChatInput" accept="application/json" />
                                <div id="clearChat">
                                    <svg width="24" height="24">
                                        <use xlink:href="#clearAllIcon" />
                                    </svg>
                                    <span>清空</span>
                                </div>
                            </div>
                            <div class="divider"></div>
                            <div style="display:none;" class="links">
                                <a href="https://github.com/xqdoo00o/chatgpt-web" target="_blank"
                                    rel="noopener noreferrer">Github</a>
                            </div>
                        </div>
                    </nav>
                    <div class="top_menu">
                        <div class="toggler" style="display:none">
                            <div class="button close"></div>
                            <div class="button minimize"></div>
                            <div class="button maximize"></div>
                        </div>
                        <div class="title">ChatGPT</div>
                        <!-- <div id="minimize"></div> -->
                        <button id="setting">
                            <svg viewBox="0 0 100 100" style="display:block;" role="img" width="30" height="30">
                                <title>设置</title>
                                <circle cx="50" cy="20" r="10" fill="#e15b64" />
                                <circle cx="50" cy="50" r="10" fill="#f8b26a" />
                                <circle cx="50" cy="80" r="10" fill="#99c959" />
                            </svg>
                        </button>
                        <div id="setDialog" style="display:none;">
                            <div class="setSwitch">
                                <div data-id="convOption" class="activeSwitch">对话</div>
                                <div data-id="speechOption">语音合成</div>
                                <div data-id="recOption">语音识别</div>
                            </div>
                            <div id="convOption">
                                <div class="presetSelect presetModelCls" style="display:none;">
                                    <label for="preSetModel">GPT模型</label>
                                    <select id="preSetModel">
                                        <option value="gpt-3.5-turbo">gpt-3.5</option>
                                        <option value="gpt-4">gpt-4</option>
                                        <option value="gpt-4-32k">gpt-4-32k</option>
                                    </select>
                                </div>
                                <div style="display:none;">
                                    <div>自定义接口</div>
                                    <input class="inputTextClass" placeholder="https://example.com/" id="apiHostInput" />
                                </div>
                                <div style="display:none;">
                                    <div>自定义API key</div>
                                    <input class="inputTextClass" type="password" placeholder="sk-xxxxxx" id="keyInput"
                                        style="-webkit-text-security: disc;" />
                                </div>
                                <div>
                                    <div class="justSetLine presetSelect">
                                        <div>系统角色</div>
                                        <div>
                                            <label for="preSetSystem">预设角色</label>
                                            <select id="preSetSystem">
                                                <option value="">默认</option>
                                                <option value="normal">助手</option>
                                                <option value="cat">猫娘</option>
                                                <option value="emoji">表情</option>
                                                <option value="image">有图</option>
                                            </select>
                                        </div>
                                    </div>
                                    <textarea class="inputTextClass areaTextClass" placeholder="你是一个乐于助人的助手，尽量简明扼要地回答"
                                        id="systemInput"></textarea>
                                </div>
                                <div>
                                    <span>角色性格</span>
                                    <input type="range" id="top_p" min="0" max="1" value="1" step="0.05" />
                                    <div class="selectDef">
                                        <span>准确严谨</span>
                                        <span>灵活创新</span>
                                    </div>
                                </div>
                                <div>
                                    <span>回答质量</span>
                                    <input type="range" id="temp" min="0" max="2" value="1" step="0.05" />
                                    <div class="selectDef">
                                        <span>重复刻板</span>
                                        <span>胡言乱语</span>
                                    </div>
                                </div>
                                <div>
                                    <span>打字机速度</span>
                                    <input type="range" id="textSpeed" min="0" max="100" value="88" step="1" />
                                    <div class="selectDef">
                                        <span>慢</span>
                                        <span>快</span>
                                    </div>
                                </div>
                                <div>
                                    <span class="inlineTitle">连续对话</span>
                                    <label class="switch-slide">
                                        <input type="checkbox" id="enableCont" checked hidden />
                                        <label for="enableCont" class="switch-slide-label"></label>
                                    </label>
                                </div>
                                <div>
                                    <span class="inlineTitle">长回复</span>
                                    <label class="switch-slide">
                                        <input type="checkbox" id="enableLongReply" hidden />
                                        <label for="enableLongReply" class="switch-slide-label"></label>
                                    </label>
                                </div>
                            </div>
                            <div id="speechOption" style="display: none;">
                                <div class="presetSelect presetModelCls">
                                    <label for="preSetService">语音合成服务</label>
                                    <select id="preSetService">
                                        <option value="3">Azure语音</option>
                                        <option selected value="2">Edge语音</option>
                                        <option value="1">系统语音</option>
                                    </select>
                                </div>
                                <div class="presetSelect presetModelCls">
                                    <label for="preSetAzureRegion">Azure 区域</label>
                                    <select id="preSetAzureRegion">
                                    </select>
                                </div>
                                <div>
                                    <div>Azure Access Key</div>
                                    <input class="inputTextClass" type="password" placeholder="Azure Key" id="azureKeyInput"
                                        style="-webkit-text-security: disc;" />
                                </div>
                                <div id="checkVoiceLoad" style="display: none;">
                                    <svg>
                                        <use xlink:href="#loadingIcon" />
                                    </svg>
                                    <span>加载语音</span>
                                </div>
                                <div id="speechDetail">
                                    <div>
                                        <div class="justSetLine">
                                            <div>语音类型</div>
                                            <div id="voiceTypes">
                                                <span data-type="0">提问语音</span>
                                                <span data-type="1" class="selVoiceType">回答语音</span>
                                            </div>
                                        </div>
                                        <select id="preSetSpeech">
                                        </select>
                                    </div>
                                    <div class="justSetLine presetSelect" id="azureExtra" style="display:none;">
                                        <div class="presetModelCls">
                                            <label for="preSetVoiceStyle">风格</label>
                                            <select id="preSetVoiceStyle">
                                            </select>
                                        </div>
                                        <div class="presetModelCls">
                                            <label for="preSetVoiceRole">角色</label>
                                            <select id="preSetVoiceRole">
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <span>音量</span>
                                        <input type="range" id="voiceVolume" min="0" max="1" value="1" step="0.1" />
                                        <div class="selectDef">
                                            <span>低</span>
                                            <span>高</span>
                                        </div>
                                    </div>
                                    <div>
                                        <span>语速</span>
                                        <input type="range" id="voiceRate" min="0.1" max="2" value="1" step="0.1" />
                                        <div class="selectDef">
                                            <span>慢</span>
                                            <span>快</span>
                                        </div>
                                    </div>
                                    <div>
                                        <span>音调</span>
                                        <input type="range" id="voicePitch" min="0" max="2" value="1" step="0.1" />
                                        <div class="selectDef">
                                            <span>平淡</span>
                                            <span>起伏</span>
                                        </div>
                                    </div>
                                    <div>
                                        <span class="inlineTitle">连续朗读</span>
                                        <label class="switch-slide">
                                            <input type="checkbox" id="enableContVoice" checked hidden />
                                            <label for="enableContVoice" class="switch-slide-label"></label>
                                        </label>
                                    </div>
                                    <div>
                                        <span class="inlineTitle">自动朗读</span>
                                        <label class="switch-slide">
                                            <input type="checkbox" id="enableAutoVoice" hidden />
                                            <label for="enableAutoVoice" class="switch-slide-label"></label>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="recOption" style="display: none;">
                                <div id="noRecTip" style="display: block;">当前环境不支持语音识别，请尝试使用chrome内核浏览器或重新部署https页面。</div>
                                <div id="yesRec" style="display: none;">
                                    <div class="presetSelect presetModelCls">
                                        <label for="selectLangOption">语言</label>
                                        <select id="selectLangOption">
                                        </select>
                                    </div>
                                    <div class="presetSelect presetModelCls">
                                        <label for="selectDiaOption">方言</label>
                                        <select id="selectDiaOption">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="messages">
                        <div id="chatlog"></div>
                        <div id="stopChat"><svg width="24" height="24">
                                <use xlink:href="#stopResIcon" />
                            </svg>停止</div>
                    </div>
                    <div class="bottom_wrapper clearfix">
                        <div class="message_input_wrapper">
                            <textarea class="message_input_text" spellcheck="false" placeholder="来问点什么吧" id="chatinput"></textarea>
                            <div id="voiceRec" style="display:none;">
                                <div id="voiceRecIcon">
                                    <svg viewBox="0 0 48 48" id="voiceInputIcon">
                                        <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                                            <rect fill="none" width="14" height="27" x="17" y="4" rx="7" />
                                            <rect class="animVoice" x="18" y="4" width="12" height="27" stroke="none"
                                                fill="currentColor"></rect>
                                            <path stroke-linecap="round"
                                                d="M9 23c0 8.284 6.716 15 15 15c8.284 0 15-6.716 15-15M24 38v6" />
                                        </g>
                                    </svg>
                                </div>
                                <div id="voiceRecSetting">
                                    <select id="select_language" style="margin-bottom: 4px;"></select>
                                    <select id="select_dialect"></select>
                                </div>
                            </div>
                        </div>
                        <button class="loaded" id="sendbutton">
                            <span>发送</span>
                            <svg style="margin:0 auto;height:40px;width:100%;">
                                <use xlink:href="#loadingIcon" />
                            </svg>
                        </button>
                        <button id="clearConv"><svg role="img" width="20px" height="20px">
                                <title>清空会话</title>
                                <use xlink:href="#deleteIcon" />
                            </svg></button>
                    </div>
                </div>
            </div>
        <!-- </div>
    </div> -->
            <link rel="stylesheet" href="//cdn.staticfile.org/notyf/3.10.0/notyf.min.css">
            <script src="//cdn.staticfile.org/notyf/3.10.0/notyf.min.js"></script>
            <script>

            const notyf = new Notyf({
                position: {x: 'center', y: 'top'},
                types: [
                    {
                        type: 'success',
                        background: '#99c959',
                        duration: 2000,
                    },
                    {
                        type: 'error',
                        background: '#e15b64',
                        duration: 3000,
                    }
                ]
            });
            document.body.addEventListener("click", event => {
                if (event.target.className === "toggler") {
                    document.body.classList.toggle("show-nav");
                } else if (event.target.className === "overlay") {
                    document.body.classList.remove("show-nav");
                } else if (event.target === document.body) {
                    document.body.classList.remove("show-nav");
                }
            });
            const content = document.getElementById('wrap_content');
            const circle = document.getElementById('wrap_circle');
            const messagsEle = document.getElementsByClassName("messages")[0];
            const chatlog = document.getElementById("chatlog");
            const stopEle = document.getElementById("stopChat");
            const sendBtnEle = document.getElementById("sendbutton");
            const textarea = document.getElementById("chatinput");
            const settingEle = document.getElementById("setting");
            const dialogEle = document.getElementById("setDialog");
            const systemEle = document.getElementById("systemInput");
            const speechServiceEle = document.getElementById("preSetService");
            const newChatEle = document.getElementById("newChat");
            const chatListEle = document.getElementById("chatList");
            const voiceRecEle = document.getElementById("voiceRecIcon");
            const voiceRecSetEle = document.getElementById("voiceRecSetting");
            // const minimizeEle = document.getElementById("minimize");
            function showContent() {
                if (document.querySelector('.wrap_circle')) {
                    circle.classList.remove('wrap_circle');
                }
                if (!document.querySelector('.show_circle')) {
                    circle.classList.add('show_circle');
                }
                if (document.querySelector('.hidden')) {
                    content.classList.toggle('hidden');
                }
            }
            // minimizeEle.onclick = (e) => {
            //     e.stopPropagation()
            //     console.log('first',circle.classList)
            //     circle.classList.add('wrap_circle');
            //     circle.classList.remove('show_circle');
            //     console.log('sec',circle.classList)
            //     console.log('third',circle)
            //     if (!document.querySelector('.hidden')) {
            //         content.classList.toggle('hidden');
            //     }
            // }
            let voiceType = 1; // 设置 0: 提问语音，1：回答语音
            let voiceRole = []; // 语音
            let voiceVolume = []; //音量
            let voiceRate = []; // 语速
            let voicePitch = []; // 音调
            let enableContVoice; // 连续朗读
            let enableAutoVoice; // 自动朗读
            let existVoice = 2; // 3:Azure语音 2:使用edge在线语音, 1:使用本地语音, 0:不支持语音
            let azureToken;
            let azureTokenTimer;
            let azureRegion;
            let azureKey;
            let azureRole = [];
            let azureStyle = [];
            let isSafeEnv = location.hostname.match(/127.|localhost/) || location.protocol.match(/https:|file:/); // https或本地安全环境
            let supportRec = !!window.webkitSpeechRecognition && isSafeEnv; // 是否支持语音识别输入
            let recing = false;
            let toggleRecEv;
            textarea.focus();
            const textInputEvent = () => {
                if (!loading) {
                    if (textarea.value.trim().length) {
                        sendBtnEle.classList.add("activeSendBtn");
                    } else {
                        sendBtnEle.classList.remove("activeSendBtn");
                    }
                }
                textarea.style.height = "47px";
                textarea.style.height = textarea.scrollHeight + "px";
            };
            textarea.oninput = textInputEvent;
            if (supportRec) {
                noRecTip.style.display = "none";
                yesRec.style.display = "block";
                document.getElementById("voiceRec").style.display = "block";
                textarea.classList.add("message_if_voice");
                let langs = [ // from https://www.google.com/intl/en/chrome/demos/speech.html
                    ['中文', ['cmn-Hans-CN', '普通话 (大陆)'],
                        ['cmn-Hans-HK', '普通话 (香港)'],
                        ['cmn-Hant-TW', '中文 (台灣)'],
                        ['yue-Hant-HK', '粵語 (香港)']],
                    ['English', ['en-US', 'United States'],
                        ['en-GB', 'United Kingdom'],
                        ['en-AU', 'Australia'],
                        ['en-CA', 'Canada'],
                        ['en-IN', 'India'],
                        ['en-KE', 'Kenya'],
                        ['en-TZ', 'Tanzania'],
                        ['en-GH', 'Ghana'],
                        ['en-NZ', 'New Zealand'],
                        ['en-NG', 'Nigeria'],
                        ['en-ZA', 'South Africa'],
                        ['en-PH', 'Philippines']]
                ];
                langs.forEach((lang, i) => {
                    select_language.options.add(new Option(lang[0], i));
                    selectLangOption.options.add(new Option(lang[0], i))
                });
                const updateCountry = function () {
                    selectLangOption.selectedIndex = select_language.selectedIndex = this.selectedIndex;
                    select_dialect.innerHTML = "";
                    selectDiaOption.innerHTML = "";
                    let list = langs[select_language.selectedIndex];
                    for (let i = 1; i < list.length; i++) {
                        select_dialect.options.add(new Option(list[i][1], list[i][0]));
                        selectDiaOption.options.add(new Option(list[i][1], list[i][0]));
                    }
                    select_dialect.style.visibility = list[1].length == 1 ? 'hidden' : 'visible';
                    selectDiaOption.parentElement.style.visibility = list[1].length == 1 ? 'hidden' : 'visible';
                    localStorage.setItem("voiceRecLang", select_dialect.value);
                };
                let localLangIdx = 0;
                let localDiaIdx = 0;
                let localRecLang = localStorage.getItem("voiceRecLang");
                if (localRecLang) {
                    let localIndex = langs.findIndex(item => {
                        let diaIdx = item.findIndex(lang => {return lang instanceof Array && lang[0] === localRecLang});
                        if (diaIdx !== -1) {
                            localDiaIdx = diaIdx - 1;
                            return true;
                        }
                        return false;
                    });
                    if (localIndex !== -1) {
                        localLangIdx = localIndex;
                    }
                }
                selectLangOption.onchange = updateCountry;
                select_language.onchange = updateCountry;
                selectDiaOption.onchange = select_dialect.onchange = function () {
                    selectDiaOption.selectedIndex = select_dialect.selectedIndex = this.selectedIndex;
                    localStorage.setItem("voiceRecLang", select_dialect.value);
                }
                selectLangOption.selectedIndex = select_language.selectedIndex = localLangIdx;
                select_language.dispatchEvent(new Event("change"));
                selectDiaOption.selectedIndex = select_dialect.selectedIndex = localDiaIdx;
                select_dialect.dispatchEvent(new Event("change"));
                let recIns = new webkitSpeechRecognition();
                // prevent some Android bug
                recIns.continuous = !(/\bAndroid\b/i.test(navigator.userAgent));
                recIns.interimResults = true;
                recIns.maxAlternatives = 1;
                let recRes = tempRes = "";
                let oriRes;
                const resEvent = (event) => {
                    if (typeof (event.results) === 'undefined') {
                        toggleRecEvent();
                        return;
                    }
                    let isFinal;
                    for (let i = event.resultIndex; i < event.results.length; ++i) {
                        isFinal = event.results[i].isFinal;
                        if (isFinal) {
                            recRes += event.results[i][0].transcript;
                        } else {
                            tempRes = recRes + event.results[i][0].transcript;
                        }
                    }
                    textarea.value = oriRes + (isFinal ? recRes : tempRes);
                    textInputEvent();
                    textarea.focus();
                };
                const endEvent = (event) => {
                    if (!(event && event.type === "end")) {
                        recIns.stop();
                    }
                    recIns.onresult = null;
                    recIns.onerror = null;
                    recIns.onend = null;
                    recRes = tempRes = "";
                    voiceRecEle.classList.remove("voiceRecing");
                    recing = false;
                };
                const errorEvent = (ev) => {
                    if (event.error === 'no-speech') {
                        notyf.error("未识别到语音，请调整设备后重试！")
                    }
                    if (event.error === 'audio-capture') {
                        notyf.error("未找到麦克风，请确保已安装麦克风！")
                    }
                    if (event.error === 'not-allowed') {
                        notyf.error("未允许使用麦克风的权限！")
                    }
                    endEvent();
                }
                const closeEvent = (ev) => {
                    if (voiceRecSetEle.contains(ev.target)) return;
                    if (!voiceRecSetEle.contains(ev.target)) {
                        voiceRecSetEle.style.display = "none";
                        document.removeEventListener("mousedown", closeEvent, true);
                        voiceRecEle.classList.remove("voiceLong");
                    }
                }
                const longEvent = () => {
                    voiceRecSetEle.style.display = "block";
                    document.addEventListener("mousedown", closeEvent, true);
                }
                const toggleRecEvent = () => {
                    voiceRecEle.classList.toggle("voiceRecing");
                    if (voiceRecEle.classList.contains("voiceRecing")) {
                        try {
                            oriRes = textarea.value;
                            recIns.lang = select_dialect.value;
                            recIns.start();
                            recIns.onresult = resEvent;
                            recIns.onerror = errorEvent;
                            recIns.onend = endEvent;
                            recing = true;
                        } catch (e) {
                            endEvent();
                        }
                    } else {
                        endEvent();
                    }
                };
                toggleRecEv = toggleRecEvent;
                let timer;
                const voiceDownEvent = (ev) => {
                    ev.preventDefault();
                    let i = 0;
                    voiceRecEle.classList.add("voiceLong");
                    timer = setInterval(() => {
                        i += 1;
                        if (i >= 3) {
                            clearInterval(timer);
                            timer = void 0;
                            longEvent();
                        }
                    }, 100)
                };
                const voiceUpEvent = (ev) => {
                    ev.preventDefault();
                    if (timer !== void 0) {
                        toggleRecEvent();
                        clearInterval(timer);
                        timer = void 0;
                        voiceRecEle.classList.remove("voiceLong");
                    }
                }
                voiceRecEle.addEventListener("mousedown", voiceDownEvent);
                voiceRecEle.addEventListener("touchstart", voiceDownEvent);
                voiceRecEle.addEventListener("mouseup", voiceUpEvent);
                voiceRecEle.addEventListener("touchend", voiceUpEvent);
            }
            document.getElementsByClassName("setSwitch")[0].onclick = function (ev) {
                let activeEle = this.getElementsByClassName("activeSwitch")[0];
                if (ev.target !== activeEle) {
                    activeEle.classList.remove("activeSwitch");
                    ev.target.classList.add("activeSwitch");
                    document.getElementById(ev.target.dataset.id).style.display = "block";
                    document.getElementById(activeEle.dataset.id).style.display = "none";
                }
            }
            let localVoiceType = localStorage.getItem("existVoice");
            if (localVoiceType) {
                existVoice = parseInt(localVoiceType);
                speechServiceEle.value = existVoice;
            }
            if (!(window.speechSynthesis && window.SpeechSynthesisUtterance)) {
                speechServiceEle.remove(2);
            }
            const clearAzureVoice = () => {
                azureKey = void 0;
                azureRegion = void 0;
                azureRole = [];
                azureStyle = [];
                document.getElementById("azureExtra").style.display = "none";
                azureKeyInput.parentElement.style.display = "none";
                preSetAzureRegion.parentElement.style.display = "none";
                if (azureTokenTimer) {
                    clearInterval(azureTokenTimer);
                    azureTokenTimer = void 0;
                }
            }
            speechServiceEle.onchange = () => {
                existVoice = parseInt(speechServiceEle.value);
                localStorage.setItem("existVoice", existVoice);
                toggleVoiceCheck(true);
                if (checkAzureAbort && !checkAzureAbort.signal.aborted) {
                    checkAzureAbort.abort();
                    checkAzureAbort = void 0;
                }
                if (checkEdgeAbort && !checkEdgeAbort.signal.aborted) {
                    checkEdgeAbort.abort();
                    checkEdgeAbort = void 0;
                }
                if (existVoice === 3) {
                    azureKeyInput.parentElement.style.display = "block";
                    preSetAzureRegion.parentElement.style.display = "block";
                    loadAzureVoice();
                } else if (existVoice === 2) {
                    clearAzureVoice();
                    loadEdgeVoice();
                } else if (existVoice === 1) {
                    toggleVoiceCheck(false);
                    clearAzureVoice();
                    loadLocalVoice();
                }
            }
            let azureVoiceData, edgeVoiceData, systemVoiceData, checkAzureAbort, checkEdgeAbort;
            const toggleVoiceCheck = (bool) => {
                checkVoiceLoad.style.display = bool ? "flex" : "none";
                speechDetail.style.display = bool ? "none" : "block";
            }
            const loadAzureVoice = () => {
                let checking = false;
                checkVoiceLoad.onclick = () => {
                    if (checking) return;
                    if (azureKey) {
                        checking = true;
                        checkVoiceLoad.classList.add("voiceChecking");
                        if (azureTokenTimer) {
                            clearInterval(azureTokenTimer);
                        }
                        checkAzureAbort = new AbortController();
                        setTimeout(() => {
                            if (checkAzureAbort && !checkAzureAbort.signal.aborted) {
                                checkAzureAbort.abort();
                                checkAzureAbort = void 0;
                            }
                        }, 15000);
                        Promise.all([getAzureToken(checkAzureAbort.signal), getVoiceList(checkAzureAbort.signal)]).then(() => {
                            azureTokenTimer = setInterval(() => {
                                getAzureToken();
                            }, 540000);
                            toggleVoiceCheck(false);
                        }).catch(e => {
                        }).finally(() => {
                            checkVoiceLoad.classList.remove("voiceChecking");
                            checking = false;
                        })
                    }
                }
                const getAzureToken = (signal) => {
                    return new Promise((res, rej) => {
                        fetch("https://" + azureRegion + ".api.cognitive.microsoft.com/sts/v1.0/issueToken", {
                            signal,
                            method: "POST",
                            headers: {
                                'Ocp-Apim-Subscription-Key': azureKey
                            }
                        }).then(response => {
                            response.text().then(text => {
                                try {
                                    let json = JSON.parse(text);
                                    notyf.error("由于订阅密钥无效或 API 端点错误，访问被拒绝！");
                                    rej();
                                } catch (e) {
                                    azureToken = text;
                                    res();
                                }
                            });
                        }).catch(e => {
                            rej();
                        })
                    })
                };
                const getVoiceList = (signal) => {
                    return new Promise((res, rej) => {
                        if (azureVoiceData) {
                            initVoiceSetting(azureVoiceData);
                            res();
                        } else {
                            let localAzureVoiceData = localStorage.getItem(azureRegion + "voiceData");
                            if (localAzureVoiceData) {
                                azureVoiceData = JSON.parse(localAzureVoiceData);
                                initVoiceSetting(azureVoiceData);
                                res();
                            } else {
                                fetch("https://" + azureRegion + ".tts.speech.microsoft.com/cognitiveservices/voices/list", {
                                    signal,
                                    headers: {
                                        'Ocp-Apim-Subscription-Key': azureKey
                                    }
                                }).then(response => {
                                    response.json().then(json => {
                                        azureVoiceData = json;
                                        localStorage.setItem(azureRegion + "voiceData", JSON.stringify(json));
                                        initVoiceSetting(json);
                                        res();
                                    }).catch(e => {
                                        notyf.error("由于订阅密钥无效或 API 端点错误，访问被拒绝！");
                                        rej();
                                    })
                                }).catch(e => {
                                    rej();
                                })
                            }
                        }
                    })
                };
                let azureRegionEle = document.getElementById("preSetAzureRegion");
                if (!azureRegionEle.options.length) {
                    const azureRegions = ['southafricanorth', 'eastasia', 'southeastasia', 'australiaeast', 'centralindia', 'japaneast', 'japanwest', 'koreacentral', 'canadacentral', 'northeurope', 'westeurope', 'francecentral', 'germanywestcentral', 'norwayeast', 'switzerlandnorth', 'switzerlandwest', 'uksouth', 'uaenorth', 'brazilsouth', 'centralus', 'eastus', 'eastus2', 'northcentralus', 'southcentralus', 'westcentralus', 'westus', 'westus2', 'westus3'];
                    azureRegions.forEach((region, i) => {
                        let option = document.createElement("option");
                        option.value = region;
                        option.text = region;
                        azureRegionEle.options.add(option);
                    });
                }
                let localAzureRegion = localStorage.getItem("azureRegion");
                if (localAzureRegion) {
                    azureRegion = localAzureRegion;
                    azureRegionEle.value = localAzureRegion;
                }
                azureRegionEle.onchange = () => {
                    azureRegion = azureRegionEle.value;
                    localStorage.setItem("azureRegion", azureRegion);
                    toggleVoiceCheck(true);
                }
                azureRegionEle.dispatchEvent(new Event("change"));
                let azureKeyEle = document.getElementById("azureKeyInput");
                let localAzureKey = localStorage.getItem("azureKey");
                if (localAzureKey) {
                    azureKey = localAzureKey;
                    azureKeyEle.value = localAzureKey;
                }
                azureKeyEle.onchange = () => {
                    azureKey = azureKeyEle.value;
                    localStorage.setItem("azureKey", azureKey);
                    toggleVoiceCheck(true);
                }
                azureKeyEle.dispatchEvent(new Event("change"));
                if (azureKey) {
                    checkVoiceLoad.dispatchEvent(new Event("click"))
                }
            }
            const loadEdgeVoice = () => {
                let checking = false;
                const endCheck = () => {
                    checkVoiceLoad.classList.remove("voiceChecking");
                    checking = false;
                };
                checkVoiceLoad.onclick = () => {
                    if (checking) return;
                    checking = true;
                    checkVoiceLoad.classList.add("voiceChecking");
                    if (edgeVoiceData) {
                        initVoiceSetting(edgeVoiceData);
                        toggleVoiceCheck(false);
                        endCheck();
                    } else {
                        checkEdgeAbort = new AbortController();
                        setTimeout(() => {
                            if (checkEdgeAbort && !checkEdgeAbort.signal.aborted) {
                                checkEdgeAbort.abort();
                                checkEdgeAbort = void 0;
                            }
                        }, 10000);
                        fetch("https://speech.platform.bing.com/consumer/speech/synthesize/readaloud/voices/list?trustedclienttoken=6A5AA1D4EAFF4E9FB37E23D68491D6F4", {signal: checkEdgeAbort.signal}).then(response => {
                            response.json().then(json => {
                                edgeVoiceData = json;
                                toggleVoiceCheck(false);
                                initVoiceSetting(json);
                                endCheck();
                            });
                        }).catch(err => {
                            endCheck();
                        })
                    }
                };
                checkVoiceLoad.dispatchEvent(new Event("click"));
            };
            const loadLocalVoice = () => {
                if (systemVoiceData) {
                    initVoiceSetting(systemVoiceData);
                } else {
                    let initedVoice = false;
                    const getLocalVoice = () => {
                        let voices = speechSynthesis.getVoices();
                        if (voices.length) {
                            if (!initedVoice) {
                                initedVoice = true;
                                systemVoiceData = voices;
                                initVoiceSetting(voices);
                            }
                            return true;
                        } else {
                            return false;
                        }
                    }
                    let syncExist = getLocalVoice();
                    if (!syncExist) {
                        if ("onvoiceschanged" in speechSynthesis) {
                            speechSynthesis.onvoiceschanged = () => {
                                getLocalVoice();
                            }
                        } else if (speechSynthesis.addEventListener) {
                            speechSynthesis.addEventListener("voiceschanged", () => {
                                getLocalVoice();
                            })
                        }
                        let timeout = 0;
                        let timer = setInterval(() => {
                            if (getLocalVoice() || timeout > 1000) {
                                if (timeout > 1000) {
                                    existVoice = 0;
                                }
                                clearInterval(timer);
                                timer = null;
                            }
                            timeout += 300;
                        }, 300)
                    }
                }
            };
            const initVoiceSetting = (voices) => {
                let isOnline = existVoice >= 2;
                let voicesEle = document.getElementById("preSetSpeech");
                // 支持中文和英文
                voices = isOnline ? voices.filter(item => item.Locale.match(/^(zh-|en-)/)) : voices.filter(item => item.lang.match(/^(zh-|en-)/));
                if (isOnline) {
                    voices.map(item => {
                        item.name = item.FriendlyName || (`${item.DisplayName} Online (${item.VoiceType}) - ${item.LocaleName}`);
                        item.lang = item.Locale;
                    })
                }
                voices.sort((a, b) => {
                    if (a.lang.slice(0, 2) === b.lang.slice(0, 2)) return 0;
                    return (a.lang < b.lang) ? 1 : -1; // 中文在前"z"
                });
                voices.map(item => {
                    if (item.name.match(/^(Google |Microsoft )/)) {
                        item.displayName = item.name.replace(/^.*? /, "");
                    } else {
                        item.displayName = item.name;
                    }
                });
                voicesEle.innerHTML = "";
                voices.forEach((voice, i) => {
                    let option = document.createElement("option");
                    option.value = i;
                    option.text = voice.displayName;
                    voicesEle.options.add(option);
                });
                voicesEle.onchange = () => {
                    voiceRole[voiceType] = voices[voicesEle.value];
                    localStorage.setItem("voice" + voiceType, voiceRole[voiceType].name);
                    if (voiceRole[voiceType].StyleList || voiceRole[voiceType].RolePlayList) {
                        document.getElementById("azureExtra").style.display = "block";
                        let voiceStyles = voiceRole[voiceType].StyleList;
                        let voiceRoles = voiceRole[voiceType].RolePlayList;
                        if (voiceRoles) {
                            preSetVoiceRole.innerHTML = "";
                            voiceRoles.forEach((role, i) => {
                                let option = document.createElement("option");
                                option.value = role;
                                option.text = role;
                                preSetVoiceRole.options.add(option);
                            });
                            let localRole = localStorage.getItem("azureRole" + voiceType);
                            if (localRole && voiceRoles.indexOf(localRole) !== -1) {
                                preSetVoiceRole.value = localRole;
                                azureRole[voiceType] = localRole;
                            } else {
                                preSetVoiceRole.selectedIndex = 0;
                                azureRole[voiceType] = voiceRole[0];
                            }
                            preSetVoiceRole.onchange = () => {
                                azureRole[voiceType] = preSetVoiceRole.value;
                                localStorage.setItem("azureRole" + voiceType, preSetVoiceRole.value);
                            }
                            preSetVoiceRole.dispatchEvent(new Event("change"));
                        } else {
                            azureRole[voiceType] = void 0;
                            localStorage.removeItem("azureRole" + voiceType);
                        }
                        preSetVoiceRole.style.display = voiceRoles ? "block" : "none";
                        preSetVoiceRole.previousElementSibling.style.display = voiceRoles ? "block" : "none";
                        if (voiceStyles) {
                            preSetVoiceStyle.innerHTML = "";
                            voiceStyles.forEach((style, i) => {
                                let option = document.createElement("option");
                                option.value = style;
                                option.text = style;
                                preSetVoiceStyle.options.add(option);
                            });
                            let localStyle = localStorage.getItem("azureStyle" + voiceType);
                            if (localStyle && voiceStyles.indexOf(localStyle) !== -1) {
                                preSetVoiceStyle.value = localStyle;
                                azureStyle[voiceType] = localStyle;
                            } else {
                                preSetVoiceStyle.selectedIndex = 0;
                                azureStyle[voiceType] = voiceStyles[0];
                            }
                            preSetVoiceStyle.onchange = () => {
                                azureStyle[voiceType] = preSetVoiceStyle.value;
                                localStorage.setItem("azureStyle" + voiceType, preSetVoiceStyle.value)
                            }
                            preSetVoiceStyle.dispatchEvent(new Event("change"));
                        } else {
                            azureStyle[voiceType] = void 0;
                            localStorage.removeItem("azureStyle" + voiceType);
                        }
                        preSetVoiceStyle.style.display = voiceStyles ? "block" : "none";
                        preSetVoiceStyle.previousElementSibling.style.display = voiceStyles ? "block" : "none";
                    } else {
                        document.getElementById("azureExtra").style.display = "none";
                        azureRole[voiceType] = void 0;
                        localStorage.removeItem("azureRole" + voiceType);
                        azureStyle[voiceType] = void 0;
                        localStorage.removeItem("azureStyle" + voiceType);
                    }
                };
                const loadAnother = (type) => {
                    type = type ^ 1;
                    let localVoice = localStorage.getItem("voice" + type);
                    if (localVoice) {
                        let localIndex = voices.findIndex(item => {return item.name === localVoice});
                        if (localIndex === -1) localIndex = 0;
                        voiceRole[type] = voices[localIndex];
                    } else {
                        voiceRole[type] = voices[0];
                    }
                    if (existVoice === 3) {
                        let localStyle = localStorage.getItem("azureStyle" + type);
                        azureStyle[type] = localStyle ? localStyle : void 0;
                        let localRole = localStorage.getItem("azureRole" + type);
                        azureRole[type] = localRole ? localRole : void 0;
                    }
                }
                const voiceChange = () => {
                    let localVoice = localStorage.getItem("voice" + voiceType);
                    if (localVoice) {
                        let localIndex = voices.findIndex(item => {return item.name === localVoice});
                        if (localIndex === -1) localIndex = 0;
                        voiceRole[voiceType] = voices[localIndex];
                        voicesEle.value = localIndex;
                    }
                    voicesEle.dispatchEvent(new Event("change"));
                }
                voiceChange();
                loadAnother(voiceType);
                let volumeEle = document.getElementById("voiceVolume");
                let localVolume = localStorage.getItem("voiceVolume0");
                voiceVolume[0] = parseFloat(localVolume ? localVolume : volumeEle.value);
                const voiceVolumeChange = () => {
                    let localVolume = localStorage.getItem("voiceVolume" + voiceType);
                    if (localVolume) {
                        voiceVolume[voiceType] = parseFloat(localVolume);
                        volumeEle.value = localVolume;
                        volumeEle.style.backgroundSize = (volumeEle.value - volumeEle.min) * 100 / (volumeEle.max - volumeEle.min) + "% 100%";
                    } else {
                        volumeEle.dispatchEvent(new Event("input"));
                    }
                }
                volumeEle.oninput = () => {
                    volumeEle.style.backgroundSize = (volumeEle.value - volumeEle.min) * 100 / (volumeEle.max - volumeEle.min) + "% 100%";
                    voiceVolume[voiceType] = parseFloat(volumeEle.value);
                    localStorage.setItem("voiceVolume" + voiceType, volumeEle.value);
                }
                voiceVolumeChange();
                let rateEle = document.getElementById("voiceRate");
                let localRate = localStorage.getItem("voiceRate0");
                voiceRate[0] = parseFloat(localRate ? localRate : rateEle.value);
                const voiceRateChange = () => {
                    let localRate = localStorage.getItem("voiceRate" + voiceType);
                    if (localRate) {
                        voiceRate[voiceType] = parseFloat(localRate);
                        rateEle.value = localRate;
                        rateEle.style.backgroundSize = (rateEle.value - rateEle.min) * 100 / (rateEle.max - rateEle.min) + "% 100%";
                    } else {
                        rateEle.dispatchEvent(new Event("input"));
                    }
                }
                rateEle.oninput = () => {
                    rateEle.style.backgroundSize = (rateEle.value - rateEle.min) * 100 / (rateEle.max - rateEle.min) + "% 100%";
                    voiceRate[voiceType] = parseFloat(rateEle.value);
                    localStorage.setItem("voiceRate" + voiceType, rateEle.value);
                }
                voiceRateChange();
                let pitchEle = document.getElementById("voicePitch");
                let localPitch = localStorage.getItem("voicePitch0");
                voicePitch[0] = parseFloat(localPitch ? localPitch : pitchEle.value);
                const voicePitchChange = () => {
                    let localPitch = localStorage.getItem("voicePitch" + voiceType);
                    if (localPitch) {
                        voicePitch[voiceType] = parseFloat(localPitch);
                        pitchEle.value = localPitch;
                        pitchEle.style.backgroundSize = (pitchEle.value - pitchEle.min) * 100 / (pitchEle.max - pitchEle.min) + "% 100%";
                    } else {
                        pitchEle.dispatchEvent(new Event("input"));
                    }
                }
                pitchEle.oninput = () => {
                    pitchEle.style.backgroundSize = (pitchEle.value - pitchEle.min) * 100 / (pitchEle.max - pitchEle.min) + "% 100%";
                    voicePitch[voiceType] = parseFloat(pitchEle.value);
                    localStorage.setItem("voicePitch" + voiceType, pitchEle.value);
                }
                voicePitchChange();
                document.getElementById("voiceTypes").onclick = (ev) => {
                    let type = ev.target.dataset.type;
                    if (type !== void 0) {
                        type = parseInt(type);
                        if (type != voiceType) {
                            voiceType = type;
                            ev.target.classList.add("selVoiceType");
                            ev.target.parentElement.children[type ^ 1].classList.remove("selVoiceType");
                            voiceChange();
                            voiceVolumeChange();
                            voiceRateChange();
                            voicePitchChange();
                        }
                    };
                };
                const contVoiceEle = document.getElementById("enableContVoice");
                let localCont = localStorage.getItem("enableContVoice");
                if (localCont) {
                    enableContVoice = localCont === "true";
                    contVoiceEle.checked = enableContVoice;
                }
                contVoiceEle.onchange = () => {
                    enableContVoice = contVoiceEle.checked;
                    localStorage.setItem("enableContVoice", enableContVoice);
                }
                contVoiceEle.dispatchEvent(new Event("change"));
                const autoVoiceEle = document.getElementById("enableAutoVoice");
                let localAuto = localStorage.getItem("enableAutoVoice");
                if (localAuto) {
                    enableAutoVoice = localAuto === "true";
                    autoVoiceEle.checked = enableAutoVoice;
                }
                autoVoiceEle.onchange = () => {
                    enableAutoVoice = autoVoiceEle.checked;
                    localStorage.setItem("enableAutoVoice", enableAutoVoice);
                }
                autoVoiceEle.dispatchEvent(new Event("change"));
            };
            speechServiceEle.dispatchEvent(new Event("change"));

            </script>
            <script src="//cdn.staticfile.org/markdown-it/13.0.1/markdown-it.min.js"></script>
            <script src="//cdn.staticfile.org/highlight.js/11.7.0/highlight.min.js"></script>
            <script src="//cdn.staticfile.org/KaTeX/0.16.4/katex.min.js"></script>
            <script src="//npm.elemecdn.com/markdown-it-texmath@1.0.0/texmath.js"></script>
            <script src="//npm.elemecdn.com/markdown-it-link-attributes@4.0.1/dist/markdown-it-link-attributes.min.js"></script>
            <script>
            const API_URL = "v1/chat/completions";
            let loading = false;
            let presetRoleData = {
                "normal": "你是一个乐于助人的助手，尽量简明扼要地回答",
                "cat": "你是一个可爱的猫娘，每句话结尾都要带个'喵'",
                "emoji": "你的性格很活泼，每句话中都要有至少一个emoji图标",
                "image": "当你需要发送图片的时候，请用 markdown 语言生成，不要反斜线，不要代码框，需要使用 unsplash API时，遵循一下格式， https://source.unsplash.com/960x640/? ＜英文关键词＞"
            };
            let modelVersion; // 模型版本
            let apiHost; // api反代地址
            let customAPIKey; // 自定义apiKey
            let systemRole; // 自定义系统角色
            let roleNature; // 角色性格
            let roleTemp; // 回答质量
            let enableCont; // 是否开启连续对话，默认开启，对话包含上下文信息。
            let enableLongReply; // 是否开启长回复，默认关闭，开启可能导致api费用增加。
            let longReplyFlag;
            let textSpeed; // 打字机速度，越小越快
            let voiceIns; // Audio or SpeechSynthesisUtterance
            let supportMSE = !!window.MediaSource; // 是否支持MSE（除了ios应该都支持）
            let voiceMIME = "audio/mpeg";
            const scrollToBottom = () => {
                if (messagsEle.scrollHeight - messagsEle.scrollTop - messagsEle.clientHeight < 128) {
                    messagsEle.scrollTo(0, messagsEle.scrollHeight)
                }
            }
            const scrollToBottomLoad = (ele) => {
                if (messagsEle.scrollHeight - messagsEle.scrollTop - messagsEle.clientHeight < ele.clientHeight + 128) {
                    messagsEle.scrollTo(0, messagsEle.scrollHeight)
                }
            }
            const md = markdownit({
                linkify: true, // 识别链接
                highlight: function (str, lang) { // markdown高亮
                    try {
                        return hljs.highlightAuto(str).value;
                    } catch (e) { }
                    return ""; // use external default escaping
                }
            });
            md.use(texmath, {engine: katex, delimiters: "dollars", katexOptions: {macros: {"\\RR": "\\mathbb{R}"}}})
                .use(markdownitLinkAttributes, {attrs: {target: "_blank", rel: "noopener"}});
            const x = {
                getCodeLang(str = "") {
                    const res = str.match(/ class="language-(.*?)"/);
                    return (res && res[1]) || "";
                },
                getFragment(str = "") {
                    return str ? `<span class="u-mdic-copy-code_lang">${str}</span>` : "";
                },
            };
            const strEncode = (str = "") => {
                if (!str || str.length === 0) return "";
                return str
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/'/g, '\'')
                    .replace(/"/g, '&quot;');
            };
            const getCodeLangFragment = (oriStr = "") => {
                return x.getFragment(x.getCodeLang(oriStr));
            };
            const copyClickCode = (ele) => {
                const input = document.createElement("textarea");
                input.value = ele.dataset.mdicContent;
                const nDom = ele.previousElementSibling;
                const nDelay = ele.dataset.mdicNotifyDelay;
                const cDom = nDom.previousElementSibling;
                document.body.appendChild(input);
                input.select();
                input.setSelectionRange(0, 9999);
                document.execCommand("copy");
                document.body.removeChild(input);
                if (nDom.style.display === "none") {
                    nDom.style.display = "block";
                    cDom && (cDom.style.display = "none");
                    setTimeout(() => {
                        nDom.style.display = "none";
                        cDom && (cDom.style.display = "block");
                    }, nDelay);
                }
            };
            const copyClickMd = (idx) => {
                const input = document.createElement("textarea");
                input.value = data[idx].content;
                document.body.appendChild(input);
                input.select();
                input.setSelectionRange(0, 9999);
                document.execCommand("copy");
                document.body.removeChild(input);
            }
            const enhanceCode = (render, options = {}) => (...args) => {
                /* args = [tokens, idx, options, env, slf] */
                const {
                    btnText = "复制代码", // button text
                    successText = "复制成功", // copy-success text
                    successTextDelay = 2000, // successText show time [ms]
                    showCodeLanguage = true, // false | show code language
                } = options;
                const [tokens = {}, idx = 0] = args;
                const cont = strEncode(tokens[idx].content || "");
                const originResult = render.apply(this, args);
                const langFrag = showCodeLanguage ? getCodeLangFragment(originResult) : "";
                const tpls = [
                    '<div class="m-mdic-copy-wrapper">',
                    `${langFrag}`,
                    `<div class="u-mdic-copy-notify" style="display:none;">${successText}</div>`,
                    '<button ',
                    'class="u-mdic-copy-btn j-mdic-copy-btn" ',
                    `data-mdic-content="${cont}" `,
                    `data-mdic-notify-delay="${successTextDelay}" `,
                    `onclick="copyClickCode(this)">${btnText}</button>`,
                    '</div>',
                ];
                const LAST_TAG = "</pre>";
                const newResult = originResult.replace(LAST_TAG, `${tpls.join("")}${LAST_TAG}`);
                return newResult;
            };
            const codeBlockRender = md.renderer.rules.code_block;
            const fenceRender = md.renderer.rules.fence;
            md.renderer.rules.code_block = enhanceCode(codeBlockRender);
            md.renderer.rules.fence = enhanceCode(fenceRender);
            md.renderer.rules.image = function (tokens, idx, options, env, slf) {
                let token = tokens[idx];
                token.attrs[token.attrIndex("alt")][1] = slf.renderInlineAsText(token.children, options, env);
                token.attrSet("onload", "scrollToBottomLoad(this);this.removeAttribute('onload');this.removeAttribute('onerror')");
                token.attrSet("onerror", "scrollToBottomLoad(this);this.removeAttribute('onload');this.removeAttribute('onerror')");
                return slf.renderToken(tokens, idx, options)
            }
            const mdOptionEvent = function (ev) {
                let id = ev.target.dataset.id;
                if (id) {
                    let parent = ev.target.parentElement;
                    let idxEle = parent.parentElement;
                    let idx = Array.prototype.indexOf.call(chatlog.children, this.parentElement);
                    if (id === "voiceMd") {
                        let className = parent.className;
                        if (className == "readyVoice") {
                            if (chatlog.children[idx].dataset.loading !== "true") {
                                idx = systemRole ? idx + 1 : idx;
                                speechEvent(idx);
                            }
                        } else if (className == "pauseVoice") {
                            if (existVoice >= 2) {
                                if (voiceIns) voiceIns.pause();
                            } else {
                                speechSynthesis.pause();
                            }
                            parent.className = "resumeVoice";
                        } else {
                            if (existVoice >= 2) {
                                if (voiceIns) voiceIns.play();
                            } else {
                                speechSynthesis.resume();
                            }
                            parent.className = "pauseVoice";
                        }
                    } else if (id === "refreshMd") {
                        if (!loading && chatlog.children[idx].dataset.loading !== "true") {
                            let className = parent.className;
                            if (className == "refreshReq") {
                                chatlog.children[idx].children[0].innerHTML = "<br />";
                                chatlog.children[idx].dataset.loading = true;
                                idx = systemRole ? idx + 1 : idx;
                                data[idx].content = "";
                                if (idx === currentVoiceIdx) {endSpeak()};
                                loadAction(true);
                                refreshIdx = idx;
                                streamGen();
                            } else {
                                chatlog.children[idx].dataset.loading = true;
                                idx = systemRole ? idx + 1 : idx;
                                progressData = data[idx].content;
                                loadAction(true);
                                refreshIdx = idx;
                                streamGen(true);
                            }
                        }
                    } else if (id === "copyMd") {
                        idxEle.classList.add("moreOptionHidden");
                        idx = systemRole ? idx + 1 : idx;
                        copyClickMd(idx);
                        notyf.success("复制成功");
                    } else if (id === "delMd") {
                        idxEle.classList.add("moreOptionHidden");
                        if (!loading) {
                            if (confirmAction("是否删除此消息?")) {
                                if (currentVoiceIdx) {
                                    if (currentVoiceIdx === idx) {endSpeak()}
                                    else if (currentVoiceIdx > idx) {currentVoiceIdx -= 1}
                                }
                                chatlog.removeChild(chatlog.children[idx]);
                                idx = systemRole ? idx + 1 : idx;
                                data.splice(idx, 1);
                                updateChats();
                            }
                        }
                    } else if (id === "downAudio") {
                        idxEle.classList.add("moreOptionHidden");
                        if (chatlog.children[idx].dataset.loading !== "true") {
                            idx = systemRole ? idx + 1 : idx;
                            downloadAudio(idx);
                        }
                    }
                }
            }
            const moreOption = (ele) => {
                ele.classList.remove("moreOptionHidden");
            }
            const formatMdEle = (ele) => {
                let realMd = document.createElement("div");
                realMd.className = ele.className === "request" ? "requestBody" : "markdown-body";
                ele.appendChild(realMd);
                let mdOption = document.createElement("div");
                mdOption.className = "mdOption";
                ele.appendChild(mdOption);
                if (ele.className !== "request") {
                    mdOption.innerHTML = `<div class="refreshReq">
                        <svg data-id="refreshMd" width="16" height="16" role="img"><title>刷新</title><use xlink:href="#refreshIcon" /></svg>
                        <svg data-id="refreshMd" width="16" height="16" role="img"><title>继续</title><use xlink:href="#halfRefIcon" /></svg>
                        </div>`
                }
                let optionWidth = existVoice >= 2 ? "96px" : "63px";
                mdOption.innerHTML += `<div class="moreOption" onmouseenter="moreOption(this)">
                <svg class="optionTrigger" width="16" height="16" role="img"><title>选项</title><use xlink:href="#optionIcon" /></svg>
                <div class="optionItems" style="width:${optionWidth};left:-${optionWidth}">` + (existVoice >= 2 ? `<div data-id="downAudio" class="optionItem" title="下载语音">
                    <svg width="20" height="20"><use xlink:href="#downAudioIcon" /></svg>
                </div>` : "") + `<div data-id="delMd" class="optionItem" title="删除">
                    <svg width="20" height="20"><use xlink:href="#delIcon" /></svg>
                </div>
                <div data-id="copyMd" class="optionItem" title="复制">
                    <svg width="20" height="20"><use xlink:href="#copyIcon" /></svg>
                </div></div></div>`;
                if (existVoice) {
                    mdOption.innerHTML += `<div id="pronMd" class="readyVoice">
                    <svg width="16" height="16" data-id="voiceMd" role="img"><title>朗读</title><use xlink:href="#readyVoiceIcon" /></svg>
                    <svg width="16" height="16" data-id="voiceMd" role="img"><title>暂停</title><use xlink:href="#pauseVoiceIcon" /></svg>
                    <svg width="16" height="16" data-id="voiceMd" role="img"><title>继续</title><use xlink:href="#resumeVoiceIcon" /></svg>
                    </div>`
                }
                mdOption.onclick = mdOptionEvent;
            }
            let chatsData = [];
            let activeChatIdx = 0;
            let data;
            const chatEleAdd = (idx) => {
                let chat = chatsData[idx];
                let chatEle = document.createElement("div");
                chatEle.className = "chatLi";
                chatEle.innerHTML = `<svg width="24" height="24"><use xlink:href="#chatIcon" /></svg>
                    <div class="chatName">${chat.name}</div>
                    <div class="chatOption"><svg data-type="chatEdit" style="margin-right:4px" width="24" height="24" role="img"><title>编辑</title><use xlink:href="#chatEditIcon" /></svg>
                    <svg data-type="chatDel" width="24" height="24" role="img"><title>删除</title><use xlink:href="#delIcon" /></svg></div>`
                chatListEle.appendChild(chatEle);
                chatEle.onclick = chatEleEvent;
                return chatEle;
            };
            const addNewChat = () => {
                let chat = {name: "新的会话", data: []};
                chatsData.push(chat);
                updateChats();
            };
            const delChat = (idx) => {
                if (confirmAction("是否删除会话?")) {
                    endAll();
                    if (idx === activeChatIdx) {
                        if (idx - 1 >= 0) {
                            activeChatIdx = idx - 1;
                        } else if (idx === chatsData.length - 1) {
                            activeChatIdx = chatsData.length - 2;
                        }
                    }
                    chatsData.splice(idx, 1);
                    chatListEle.children[idx].remove();
                    if (activeChatIdx === -1) {
                        addNewChat();
                        activeChatIdx = 0;
                        chatEleAdd(activeChatIdx);
                    }
                    updateChats();
                    activeChat();
                }
            };
            const endEditEvent = (ev) => {
                let activeEle = document.getElementById("activeChatEdit")
                if (!activeEle.contains(ev.target)) {
                    let ele = chatListEle.children[activeChatIdx];
                    chatsData[activeChatIdx].name = activeEle.value;
                    ele.children[1].textContent = activeEle.value;
                    ele.lastElementChild.remove();
                    updateChats();
                    document.body.removeEventListener("mousedown", endEditEvent, true);
                }
            };
            const toEditChatName = (idx) => {
                let inputEle = document.createElement("input");
                inputEle.id = "activeChatEdit";
                inputEle.value = chatsData[idx].name;
                chatListEle.children[idx].appendChild(inputEle);
                inputEle.focus();
                document.body.addEventListener("mousedown", endEditEvent, true);
            };
            const chatEleEvent = function (ev) {
                ev.preventDefault();
                ev.stopPropagation();
                let idx = Array.prototype.indexOf.call(chatListEle.children, this);
                if (ev.target.className === "chatLi") {
                    if (activeChatIdx !== idx) {
                        endAll();
                        activeChatIdx = idx;
                        activeChat();
                    }
                    document.body.classList.remove("show-nav");
                } else if (ev.target.dataset.type === "chatEdit") {
                    toEditChatName(idx);
                } else if (ev.target.dataset.type === "chatDel") {
                    delChat(idx);
                }
            };
            const updateChats = () => {
                localStorage.setItem("chats", JSON.stringify(chatsData));
            };
            const createConvEle = (className) => {
                let div = document.createElement("div");
                div.className = className;
                chatlog.appendChild(div);
                formatMdEle(div);
                return div;
            }
            const activeChat = () => {
                data = chatsData[activeChatIdx]["data"];
                Array.from(document.getElementsByClassName("activeChatLi")).forEach(item => {
                    item.classList.remove("activeChatLi");
                });
                chatListEle.children[activeChatIdx].classList.add("activeChatLi");
                if (data[0] && data[0].role === "system") {
                    systemRole = data[0].content;
                    systemEle.value = systemRole;
                    localStorage.setItem("system", systemRole);
                } else {
                    systemRole = "";
                    systemEle.value = "";
                    localStorage.setItem("system", systemRole);
                }
                chatlog.innerHTML = "";
                if (systemRole ? data.length - 1 : data.length) {
                    let firstIdx = systemRole ? 1 : 0;
                    for (let i = firstIdx; i < data.length; i++) {
                        createConvEle(data[i].role === "user" ? "request" : "response").children[0].innerHTML = data[i].role === "user" ? data[i].content : (md.render(data[i].content) || "<br />");
                    }
                }
                localStorage.setItem("activeChatIdx", activeChatIdx);
            };
            newChatEle.onclick = () => {
                endAll();
                addNewChat();
                activeChatIdx = chatsData.length - 1;
                chatEleAdd(activeChatIdx);
                activeChat();
            };
            const initChats = () => {
                let localChats = localStorage.getItem("chats");
                let localChatIdx = localStorage.getItem("activeChatIdx")
                activeChatIdx = (localChatIdx && parseInt(localChatIdx)) || 0;
                if (localChats) {
                    chatsData = JSON.parse(localChats);
                    for (let i = 0; i < chatsData.length; i++) {
                        chatEleAdd(i);
                    }
                } else {
                    addNewChat();
                    chatEleAdd(activeChatIdx);
                }
            };
            initChats();
            activeChat();
            document.getElementById("exportChat").onclick = () => {
                if (loading) {
                    stopLoading();
                }
                let blob = new Blob([JSON.stringify(chatsData, null, 2)], {type: "application/json"});
                let date = new Date();
                let fileName = "chats-" + date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate() + ".json";
                downBlob(blob, fileName);
            };
            const blobToText = (blob) => {
                return new Promise((res, rej) => {
                    let reader = new FileReader();
                    reader.readAsText(blob);
                    reader.onload = () => {
                        res(reader.result);
                    }
                    reader.onerror = (error) => {
                        rej(error);
                    }
                })
            };
            document.getElementById("importChatInput").onchange = function () {
                let file = this.files[0];
                blobToText(file).then(text => {
                    try {
                        let json = JSON.parse(text);
                        let checked = json.every(item => {
                            return item.name !== void 0 && item.data !== void 0;
                        });
                        if (checked) {
                            while (json.length) {
                                chatsData.push(json.shift());
                                chatEleAdd(chatsData.length - 1);
                            }
                            updateChats();
                        } else {
                            throw new Error("格式检查不通过")
                        }
                    } catch (e) {
                        notyf.error("导入失败，请检查文件是否正确！")
                    }
                    this.value = "";
                })
            };
            document.getElementById("clearChat").onclick = () => {
                if (confirmAction("是否清空所有会话?")) {
                    chatsData.length = 0;
                    chatListEle.innerHTML = "";
                    endAll();
                    addNewChat();
                    activeChatIdx = 0;
                    chatEleAdd(activeChatIdx);
                    updateChats();
                    activeChat();
                }
            };
            const endAll = () => {
                endSpeak();
                if (loading) stopLoading();
            };
            const initSetting = () => {
                const modelEle = document.getElementById("preSetModel");
                let localModel = localStorage.getItem("modelVersion");
                if (localModel) {
                    modelVersion = localModel;
                    modelEle.value = localModel;
                }
                modelEle.onchange = () => {
                    modelVersion = modelEle.value;
                    localStorage.setItem("modelVersion", modelVersion);
                }
                modelEle.dispatchEvent(new Event("change"));
                const apiHostEle = document.getElementById("apiHostInput");
                let localApiHost = localStorage.getItem("APIHost");
                if (localApiHost) {
                    apiHost = localApiHost;
                    apiHostEle.value = localApiHost;
                }
                apiHostEle.onchange = () => {
                    apiHost = apiHostEle.value;
                    if (apiHost.length && !apiHost.endsWith("/")) {
                        apiHost += "/";
                        apiHostEle.value = apiHost;
                    }
                    localStorage.setItem("APIHost", apiHost);
                }
                apiHostEle.dispatchEvent(new Event("change"));
                const keyEle = document.getElementById("keyInput");
                let localKey = localStorage.getItem("APIKey");
                if (localKey) {
                    customAPIKey = localKey;
                    keyEle.value = localKey;
                }
                keyEle.onchange = () => {
                    customAPIKey = keyEle.value;
                    localStorage.setItem("APIKey", customAPIKey);
                }
                keyEle.dispatchEvent(new Event("change"));
                if (systemRole === void 0) {
                    let localSystem = localStorage.getItem("system");
                    if (localSystem) {
                        systemRole = localSystem;
                        systemEle.value = localSystem;
                        data.unshift({role: "system", content: systemRole});
                        updateChats();
                    } else {
                        systemRole = systemEle.value;
                    }
                }
                systemEle.onchange = () => {
                    systemRole = systemEle.value;
                    localStorage.setItem("system", systemRole);
                    if (systemRole) {
                        if (data[0] && data[0].role === "system") {
                            data[0].content = systemRole;
                        } else {
                            data.unshift({role: "system", content: systemRole});
                        }
                    } else if (data[0] && data[0].role === "system") {
                        data.shift();
                    }
                    updateChats();
                }
                const preEle = document.getElementById("preSetSystem");
                preEle.onchange = () => {
                    let val = preEle.value;
                    if (val && presetRoleData[val]) {
                        systemEle.value = presetRoleData[val];
                    } else {
                        systemEle.value = "";
                    }
                    systemEle.dispatchEvent(new Event("change"));
                    systemEle.focus();
                }
                const topEle = document.getElementById("top_p");
                let localTop = localStorage.getItem("top_p");
                if (localTop) {
                    roleNature = parseFloat(localTop);
                    topEle.value = localTop;
                }
                topEle.oninput = () => {
                    topEle.style.backgroundSize = (topEle.value - topEle.min) * 100 / (topEle.max - topEle.min) + "% 100%";
                    roleNature = parseFloat(topEle.value);
                    localStorage.setItem("top_p", topEle.value);
                }
                topEle.dispatchEvent(new Event("input"));
                const tempEle = document.getElementById("temp");
                let localTemp = localStorage.getItem("temp");
                if (localTemp) {
                    roleTemp = parseFloat(localTemp);
                    tempEle.value = localTemp;
                }
                tempEle.oninput = () => {
                    tempEle.style.backgroundSize = (tempEle.value - tempEle.min) * 100 / (tempEle.max - tempEle.min) + "% 100%";
                    roleTemp = parseFloat(tempEle.value);
                    localStorage.setItem("temp", tempEle.value);
                }
                tempEle.dispatchEvent(new Event("input"));
                const speedEle = document.getElementById("textSpeed");
                let localSpeed = localStorage.getItem("textSpeed");
                if (localSpeed) {
                    textSpeed = parseFloat(speedEle.min) + (speedEle.max - localSpeed);
                    speedEle.value = localSpeed;
                }
                speedEle.oninput = () => {
                    speedEle.style.backgroundSize = (speedEle.value - speedEle.min) * 100 / (speedEle.max - speedEle.min) + "% 100%";
                    textSpeed = parseFloat(speedEle.min) + (speedEle.max - speedEle.value);
                    localStorage.setItem("textSpeed", speedEle.value);
                }
                speedEle.dispatchEvent(new Event("input"));
                const contEle = document.getElementById("enableCont");
                let localCont = localStorage.getItem("enableCont");
                if (localCont) {
                    enableCont = localCont === "true";
                    contEle.checked = enableCont;
                }
                contEle.onchange = () => {
                    enableCont = contEle.checked;
                    localStorage.setItem("enableCont", enableCont);
                }
                contEle.dispatchEvent(new Event("change"));
                const longEle = document.getElementById("enableLongReply");
                let localLong = localStorage.getItem("enableLongReply");
                if (localLong) {
                    enableLongReply = localLong === "true";
                    longEle.checked = enableLongReply;
                }
                longEle.onchange = () => {
                    enableLongReply = longEle.checked;
                    localStorage.setItem("enableLongReply", enableLongReply);
                }
                longEle.dispatchEvent(new Event("change"));
            };
            initSetting();
            document.getElementById("loadMask").style.display = "none";
            const closeEvent = (ev) => {
                if (settingEle.contains(ev.target)) return;
                if (!dialogEle.contains(ev.target)) {
                    dialogEle.style.display = "none";
                    document.removeEventListener("mousedown", closeEvent, true);
                    settingEle.classList.remove("showSetting");
                }
            }
            settingEle.onmousedown = () => {
                dialogEle.style.display = dialogEle.style.display === "block" ? "none" : "block";
                if (dialogEle.style.display === "block") {
                    document.addEventListener("mousedown", closeEvent, true);
                    settingEle.classList.add("showSetting");
                } else {
                    document.removeEventListener("mousedown", closeEvent, true);
                    settingEle.classList.remove("showSetting");
                }
            }
            let delayId;
            const delay = () => {
                return new Promise((resolve) => delayId = setTimeout(resolve, textSpeed)); //打字机时间间隔
            }
            const uuidv4 = () => {
                let uuid = ([1e7] + 1e3 + 4e3 + 8e3 + 1e11).replace(/[018]/g, c =>
                    (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
                );
                return existVoice === 3 ? uuid.toUpperCase() : uuid;
            }
            const getTime = () => {
                return existVoice === 3 ? new Date().toISOString() : new Date().toString();
            }
            const getWSPre = (date, requestId) => {
                let osPlatform = (typeof window !== "undefined") ? "Browser" : "Node";
                osPlatform += "/" + navigator.platform;
                let osName = navigator.userAgent;
                let osVersion = navigator.appVersion;
                return `Path: speech.config\r\nX-RequestId: ${requestId}\r\nX-Timestamp: ${date}\r\nContent-Type: application/json\r\n\r\n{"context":{"system":{"name":"SpeechSDK","version":"1.26.0","build":"JavaScript","lang":"JavaScript","os":{"platform":"${osPlatform}","name":"${osName}","version":"${osVersion}"}}}}`
            }
            const getWSAudio = (date, requestId) => {
                return existVoice === 3 ? `Path: synthesis.context\r\nX-RequestId: ${requestId}\r\nX-Timestamp: ${date}\r\nContent-Type: application/json\r\n\r\n{"synthesis":{"audio":{"metadataOptions":{"sentenceBoundaryEnabled":false,"wordBoundaryEnabled":false},"outputFormat":"audio-24khz-48kbitrate-mono-mp3"}}}`
                    : `X-Timestamp:${date}\r\nContent-Type:application/json; charset=utf-8\r\nPath:speech.config\r\n\r\n{"context":{"synthesis":{"audio":{"metadataoptions":{"sentenceBoundaryEnabled":"false","wordBoundaryEnabled":"true"},"outputFormat":"audio-24khz-48kbitrate-mono-mp3"}}}}`
            }
            const getWSText = (date, requestId, lang, voice, volume, rate, pitch, style, role, msg) => {
                let fmtVolume = volume === 1 ? "+0%" : volume * 100 - 100 + "%";
                let fmtRate = (rate >= 1 ? "+" : "") + (rate * 100 - 100) + "%";
                let fmtPitch = (pitch >= 1 ? "+" : "") + (pitch - 1) + "Hz";
                if (existVoice === 3) {
                    let fmtStyle = style ? ` style="${style}"` : "";
                    let fmtRole = role ? ` role="${role}"` : "";
                    let fmtExpress = fmtStyle + fmtRole;
                    return `Path: ssml\r\nX-RequestId: ${requestId}\r\nX-Timestamp: ${date}\r\nContent-Type: application/ssml+xml\r\n\r\n<speak version='1.0' xmlns='http://www.w3.org/2001/10/synthesis' xmlns:mstts='https://www.w3.org/2001/mstts' xml:lang='${lang}'><voice name='${voice}'><mstts:express-as${fmtExpress}><prosody pitch='${fmtPitch}' rate='${fmtRate}' volume='${fmtVolume}'>${msg}</prosody></mstts:express-as></voice></speak>`;
                } else {
                    return `X-RequestId:${requestId}\r\nContent-Type:application/ssml+xml\r\nX-Timestamp:${date}Z\r\nPath:ssml\r\n\r\n<speak version='1.0' xmlns='http://www.w3.org/2001/10/synthesis' xmlns:mstts='https://www.w3.org/2001/mstts' xml:lang='${lang}'><voice name='${voice}'><prosody pitch='${fmtPitch}' rate='${fmtRate}' volume='${fmtVolume}'>${msg}</prosody></voice></speak>`;
                }
            }
            const getAzureWSURL = () => {
                return `wss://${azureRegion}.tts.speech.microsoft.com/cognitiveservices/websocket/v1?Authorization=bearer%20${azureToken}`
            }
            const edgeTTSURL = "wss://speech.platform.bing.com/consumer/speech/synthesize/readaloud/edge/v1?trustedclienttoken=6A5AA1D4EAFF4E9FB37E23D68491D6F4";
            let currentVoiceIdx;
            const resetSpeakIcon = () => {
                if (currentVoiceIdx !== void 0) {
                    chatlog.children[systemRole ? currentVoiceIdx - 1 : currentVoiceIdx].children[1].lastChild.className = "readyVoice";
                }
            }
            const endSpeak = () => {
                resetSpeakIcon();
                if (existVoice >= 2) {
                    if (voiceIns) {
                        voiceIns.pause();
                        voiceIns.currentTime = 0;
                        URL.revokeObjectURL(voiceIns.src);
                        voiceIns.removeAttribute("src");
                        voiceIns.onended = voiceIns.onerror = null;
                    }
                    sourceBuffer = void 0;
                    speechPushing = false;
                    if (voiceSocket && voiceSocket["pending"]) {
                        voiceSocket.close()
                    }
                    if (autoVoiceSocket && autoVoiceSocket["pending"]) {
                        autoVoiceSocket.close()
                    }
                    speechQuene.length = 0;
                    autoMediaSource = void 0;
                    voiceContentQuene = [];
                    voiceEndFlagQuene = [];
                    voiceBlobURLQuene = [];
                    autoOnlineVoiceFlag = false;
                } else {
                    speechSynthesis.cancel();
                }
                currentVoiceIdx = void 0;
            }
            const speakEvent = (ins, force = true, end = false) => {
                return new Promise((res, rej) => {
                    ins.onerror = () => {
                        if (end) {
                            endSpeak();
                        } else if (force) {
                            resetSpeakIcon();
                        }
                        res();
                    }
                    if (existVoice >= 2) {
                        ins.onended = ins.onerror;
                        ins.play();
                    } else {
                        ins.onend = ins.onerror;
                        speechSynthesis.speak(voiceIns);
                    }
                })
            };
            let voiceData = [];
            let voiceSocket;
            let speechPushing = false;
            let speechQuene = [];
            let sourceBuffer;
            speechQuene.push = function (buffer) {
                if (!speechPushing && !sourceBuffer.updating) {
                    speechPushing = true;
                    sourceBuffer.appendBuffer(buffer);
                } else {
                    Array.prototype.push.call(this, buffer)
                }
            }
            const initSocket = () => {
                return new Promise((res, rej) => {
                    if (!voiceSocket || voiceSocket.readyState > 1) {
                        voiceSocket = new WebSocket(existVoice === 3 ? getAzureWSURL() : edgeTTSURL);
                        voiceSocket.binaryType = "arraybuffer";
                        voiceSocket.onopen = () => {
                            res();
                        };
                        voiceSocket.onerror = () => {
                            rej();
                        }
                    } else {
                        return res();
                    }
                })
            }
            const initStreamVoice = (mediaSource) => {
                return new Promise((r, j) => {
                    Promise.all([initSocket(), new Promise(res => {
                        mediaSource.onsourceopen = () => {
                            res();
                        };
                    })]).then(() => {
                        r();
                    })
                })
            }
            let downQuene = {};
            let downSocket;
            const downBlob = (blob, name) => {
                let a = document.createElement("a");
                a.download = name;
                a.href = URL.createObjectURL(blob);
                a.click();
            }
            const initDownSocket = () => {
                return new Promise((res, rej) => {
                    if (!downSocket || downSocket.readyState > 1) {
                        downSocket = new WebSocket(existVoice === 3 ? getAzureWSURL() : edgeTTSURL);
                        downSocket.binaryType = "arraybuffer";
                        downSocket.onopen = () => {
                            res();
                        };
                        downSocket.onmessage = (e) => {
                            if (e.data instanceof ArrayBuffer) {
                                let text = new TextDecoder().decode(e.data.slice(0, 130));
                                let reqIdx = text.indexOf(":");
                                let uuid = text.slice(reqIdx + 1, reqIdx + 33);
                                downQuene[uuid]["blob"].push(e.data.slice(130));
                            } else if (e.data.indexOf("Path:turn.end") !== -1) {
                                let reqIdx = e.data.indexOf(":");
                                let uuid = e.data.slice(reqIdx + 1, reqIdx + 33);
                                let blob = new Blob(downQuene[uuid]["blob"], {type: voiceMIME});
                                let key = downQuene[uuid]["key"];
                                let name = downQuene[uuid]["name"];
                                voiceData[key] = blob;
                                downBlob(blob, name.slice(0, 16) + ".mp3");
                            }
                        }
                        downSocket.onerror = () => {
                            rej();
                        }
                    } else {
                        return res();
                    }
                })
            }
            const downloadAudio = async (idx) => {
                if (existVoice < 2) {
                    return;
                }
                let type = data[idx].role === "user" ? 0 : 1;
                let voice = existVoice === 3 ? voiceRole[type].ShortName : voiceRole[type].Name;
                let volume = voiceVolume[type];
                let rate = voiceRate[type];
                let pitch = voicePitch[type];
                let style = azureStyle[type];
                let role = azureRole[type];
                let content = data[idx].content;
                let key = content + voice + volume + rate + pitch + (style ? style : "") + (role ? role : "");
                let blob = voiceData[key];
                if (blob) {
                    downBlob(blob, content.slice(0, 16) + ".mp3");
                } else {
                    await initDownSocket();
                    let currDate = getTime();
                    let lang = voiceRole[type].lang;
                    let uuid = uuidv4();
                    if (existVoice === 3) {
                        downSocket.send(getWSPre(currDate, uuid));
                    }
                    downSocket.send(getWSAudio(currDate, uuid));
                    downSocket.send(getWSText(currDate, uuid, lang, voice, volume, rate, pitch, style, role, content));
                    downSocket["pending"] = true;
                    downQuene[uuid] = {};
                    downQuene[uuid]["name"] = content;
                    downQuene[uuid]["key"] = key;
                    downQuene[uuid]["blob"] = [];
                }
            }
            const NoMSEPending = (key) => {
                return new Promise((res, rej) => {
                    let bufArray = [];
                    voiceSocket.onmessage = (e) => {
                        if (e.data instanceof ArrayBuffer) {
                            bufArray.push(e.data.slice(130));
                        } else if (e.data.indexOf("Path:turn.end") !== -1) {
                            voiceSocket["pending"] = false;
                            voiceData[key] = new Blob(bufArray, {type: voiceMIME});
                            res(voiceData[key]);
                        }
                    }
                })
            }
            const speechEvent = async (idx) => {
                if (!data[idx]) return;
                endSpeak();
                currentVoiceIdx = idx;
                if (!data[idx].content && enableContVoice) {
                    if (currentVoiceIdx !== data.length - 1) {return speechEvent(currentVoiceIdx + 1)}
                    else {return endSpeak()}
                };
                let type = data[idx].role === "user" ? 0 : 1;
                chatlog.children[systemRole ? idx - 1 : idx].children[1].lastChild.className = "pauseVoice";
                let content = data[idx].content;
                let volume = voiceVolume[type];
                let rate = voiceRate[type];
                let pitch = voicePitch[type];
                let style = azureStyle[type];
                let role = azureRole[type];
                if (existVoice >= 2) {
                    if (!voiceIns) {
                        voiceIns = new Audio();
                    }
                    let voice = existVoice === 3 ? voiceRole[type].ShortName : voiceRole[type].Name;
                    let key = content + voice + volume + rate + pitch + (style ? style : "") + (role ? role : "");
                    let currData = voiceData[key];
                    if (currData) {
                        voiceIns.src = URL.createObjectURL(currData);
                    } else {
                        let mediaSource;
                        if (supportMSE) {
                            mediaSource = new MediaSource();
                            voiceIns.src = URL.createObjectURL(mediaSource);
                            await initStreamVoice(mediaSource);
                            if (!sourceBuffer) {
                                sourceBuffer = mediaSource.addSourceBuffer(voiceMIME);
                            }
                            sourceBuffer.onupdateend = function () {
                                speechPushing = false;
                                if (speechQuene.length) {
                                    let buf = speechQuene.shift();
                                    if (buf["end"]) {
                                        mediaSource.endOfStream();
                                    } else {
                                        speechPushing = true;
                                        sourceBuffer.appendBuffer(buf);
                                    }
                                }
                            };
                            let bufArray = [];
                            voiceSocket.onmessage = (e) => {
                                if (e.data instanceof ArrayBuffer) {
                                    let buf = e.data.slice(130);
                                    bufArray.push(buf);
                                    speechQuene.push(buf);
                                } else if (e.data.indexOf("Path:turn.end") !== -1) {
                                    voiceSocket["pending"] = false;
                                    voiceData[key] = new Blob(bufArray, {type: voiceMIME});
                                    if (!speechQuene.length && !speechPushing) {
                                        mediaSource.endOfStream();
                                    } else {
                                        let buf = new ArrayBuffer();
                                        buf["end"] = true;
                                        speechQuene.push(buf);
                                    }
                                }
                            }
                        } else {
                            await initSocket();
                        }
                        let currDate = getTime();
                        let lang = voiceRole[type].lang;
                        let uuid = uuidv4();
                        if (existVoice === 3) {
                            voiceSocket.send(getWSPre(currDate, uuid));
                        }
                        voiceSocket.send(getWSAudio(currDate, uuid));
                        voiceSocket.send(getWSText(currDate, uuid, lang, voice, volume, rate, pitch, style, role, content));
                        voiceSocket["pending"] = true;
                        if (!supportMSE) {
                            let blob = await NoMSEPending(key);
                            voiceIns.src = URL.createObjectURL(blob);
                        }
                    }
                } else {
                    if (!voiceIns) {
                        voiceIns = new SpeechSynthesisUtterance();
                    }
                    voiceIns.voice = voiceRole[type];
                    voiceIns.volume = volume;
                    voiceIns.rate = rate;
                    voiceIns.pitch = pitch;
                    voiceIns.text = content;
                }
                await speakEvent(voiceIns);
                if (enableContVoice) {
                    if (currentVoiceIdx !== data.length - 1) {return speechEvent(currentVoiceIdx + 1)}
                    else {endSpeak()}
                }
            };
            let autoVoiceSocket;
            let autoMediaSource;
            let voiceContentQuene = [];
            let voiceEndFlagQuene = [];
            let voiceBlobURLQuene = [];
            let autoOnlineVoiceFlag = false;
            const autoAddQuene = () => {
                if (voiceContentQuene.length) {
                    let content = voiceContentQuene.shift();
                    let currDate = getTime();
                    let uuid = uuidv4();
                    let voice = voiceRole[1].Name;
                    if (existVoice === 3) {
                        autoVoiceSocket.send(getWSPre(currDate, uuid));
                        voice = voiceRole[1].ShortName;
                    }
                    autoVoiceSocket.send(getWSAudio(currDate, uuid));
                    autoVoiceSocket.send(getWSText(currDate, uuid, voiceRole[1].lang, voice, voiceVolume[1], voiceRate[1], voicePitch[1], azureStyle[1], azureRole[1], content));
                    autoVoiceSocket["pending"] = true;
                    autoOnlineVoiceFlag = true;
                }
            }
            const autoSpeechEvent = (content, ele, force = false, end = false) => {
                if (ele.children[1].lastChild.className === "readyVoice") {
                    ele.children[1].lastChild.className = "pauseVoice";
                }
                if (existVoice >= 2) {
                    voiceContentQuene.push(content);
                    voiceEndFlagQuene.push(end);
                    if (!voiceIns) {
                        voiceIns = new Audio();
                    }
                    if (!autoVoiceSocket || autoVoiceSocket.readyState > 1) {
                        autoVoiceSocket = new WebSocket(existVoice === 3 ? getAzureWSURL() : edgeTTSURL);
                        autoVoiceSocket.binaryType = "arraybuffer";
                        autoVoiceSocket.onopen = () => {
                            autoAddQuene();
                        };

                        autoVoiceSocket.onerror = () => {
                            autoOnlineVoiceFlag = false;
                        };
                    };
                    let bufArray = [];
                    autoVoiceSocket.onmessage = (e) => {
                        if (e.data instanceof ArrayBuffer) {
                            (supportMSE ? speechQuene : bufArray).push(e.data.slice(130));
                        } else {
                            if (e.data.indexOf("Path:turn.end") !== -1) {
                                autoVoiceSocket["pending"] = false;
                                autoOnlineVoiceFlag = false;
                                if (!supportMSE) {
                                    let blob = new Blob(bufArray, {type: voiceMIME});
                                    bufArray = [];
                                    if (blob.size) {
                                        let blobURL = URL.createObjectURL(blob);
                                        if (!voiceIns.src) {
                                            voiceIns.src = blobURL;
                                            voiceIns.play();
                                        } else {
                                            voiceBlobURLQuene.push(blobURL);
                                        }
                                    }
                                    autoAddQuene();
                                }
                                if (voiceEndFlagQuene.shift()) {
                                    if (supportMSE) {
                                        if (!speechQuene.length && !speechPushing) {
                                            autoMediaSource.endOfStream();
                                        } else {
                                            let buf = new ArrayBuffer();
                                            buf["end"] = true;
                                            speechQuene.push(buf);
                                        }
                                    } else {
                                        if (!voiceBlobURLQuene.length && !voiceIns.src) {
                                            endSpeak();
                                        } else {
                                            voiceBlobURLQuene.push("end");
                                        }
                                    }
                                };
                                if (supportMSE) {
                                    autoAddQuene();
                                }
                            }
                        }
                    };
                    if (!autoOnlineVoiceFlag && autoVoiceSocket.readyState) {
                        autoAddQuene();
                    }
                    if (supportMSE) {
                        if (!autoMediaSource) {
                            autoMediaSource = new MediaSource();
                            autoMediaSource.onsourceopen = () => {
                                if (!sourceBuffer) {
                                    sourceBuffer = autoMediaSource.addSourceBuffer(voiceMIME);
                                    sourceBuffer.onupdateend = () => {
                                        speechPushing = false;
                                        if (speechQuene.length) {
                                            let buf = speechQuene.shift();
                                            if (buf["end"]) {
                                                autoMediaSource.endOfStream();
                                            } else {
                                                speechPushing = true;
                                                sourceBuffer.appendBuffer(buf);
                                            }
                                        }
                                    };
                                }
                            }
                        }
                        if (!voiceIns.src) {
                            voiceIns.src = URL.createObjectURL(autoMediaSource);
                            voiceIns.play();
                            voiceIns.onended = voiceIns.onerror = () => {
                                endSpeak();
                            }
                        }
                    } else {
                        voiceIns.onended = voiceIns.onerror = () => {
                            if (voiceBlobURLQuene.length) {
                                let src = voiceBlobURLQuene.shift();
                                if (src === "end") {
                                    endSpeak();
                                } else {
                                    voiceIns.src = src;
                                    voiceIns.currentTime = 0;
                                    voiceIns.play();
                                }
                            } else {
                                voiceIns.currentTime = 0;
                                voiceIns.removeAttribute("src");
                            }
                        }
                    }
                } else {
                    voiceIns = new SpeechSynthesisUtterance(content);
                    voiceIns.volume = voiceVolume[1];
                    voiceIns.rate = voiceRate[1];
                    voiceIns.pitch = voicePitch[1];
                    voiceIns.voice = voiceRole[1];
                    speakEvent(voiceIns, force, end);
                }
            };
            const confirmAction = (prompt) => {
                if (window.confirm(prompt)) {
                    return true;
                }
                else {
                    return false;
                }
            };
            let autoVoiceIdx = 0;
            let autoVoiceDataIdx;
            let controller;
            let controllerId;
            let refreshIdx;
            let currentResEle;
            let progressData = "";
            const streamGen = async (long) => {
                controller = new AbortController();
                controllerId = setTimeout(() => {
                    notyf.error("请求超时，请稍后重试！");
                    stopLoading();
                }, 30000);
                let headers = {"Content-Type": "application/json"};
                if (customAPIKey) headers["Authorization"] = "Bearer " + customAPIKey;
                let isRefresh = refreshIdx !== void 0;
                if (isRefresh) {
                    currentResEle = chatlog.children[systemRole ? refreshIdx - 1 : refreshIdx];
                } else if (!currentResEle) {
                    currentResEle = createConvEle("response");
                    currentResEle.children[0].innerHTML = "<br />";
                    currentResEle.dataset.loading = true;
                    scrollToBottom();
                }
                let idx = isRefresh ? refreshIdx : data.length;
                if (existVoice && enableAutoVoice && !long) {
                    if (isRefresh) {
                        endSpeak();
                        autoVoiceDataIdx = currentVoiceIdx = idx;
                    } else if (currentVoiceIdx !== data.length) {
                        endSpeak();
                        autoVoiceDataIdx = currentVoiceIdx = idx;
                    }
                }
                let dataSlice;
                if (long) {
                    idx = isRefresh ? refreshIdx : data.length - 1;
                    dataSlice = [data[idx - 1], data[idx]];
                    if (systemRole) {dataSlice.unshift(data[0]);}
                } else if (enableCont) {
                    dataSlice = data.slice(0, idx);
                } else {
                    dataSlice = [data[idx - 1]];
                    if (systemRole) {dataSlice.unshift(data[0]);}
                }
                try {
                    const res = await fetch('http://api-aigc.hotsalecloud.com/aigc/chat/chatCompletion', {
                        method: "POST",
                        headers: {
                        'Content-Type': 'application/json',
                        'License-Authorization': '8c30b556a9a54cf58a5301e21836f9a1'
                        },
                        body: JSON.stringify({data:JSON.stringify({
                            model: "gpt-3.5-turbo",
                            messages: dataSlice,
                            temperature: roleTemp,
                            n: 1,
                            max_tokens: 1000,
                            frequency_penalty: 0,
                            presence_penalty: 0,
                            user: "1_1",
                            // stream: true,
                        })}),
                        signal: controller.signal
                    });

                    clearTimeout(controllerId);
                    controllerId = void 0;
                    if (res.status !== 200) {
                        if (res.status === 401) {
                            notyf.error("API key错误或失效，请检查API key！")
                        } else if (res.status === 400) {
                            notyf.error("请求内容过大，请删除部分对话或打开设置关闭连续对话！");
                        } else if (res.status === 404) {
                            notyf.error("无权使用此模型，请打开设置选择其他GPT模型！");
                        } else if (res.status === 429) {
                            notyf.error(res.statusText ? "触发API调用频率限制，请稍后重试！" : "API使用超出限额，请检查您的账单！");
                        } else {
                            notyf.error("网关错误或超时，请稍后重试！");
                        }
                        stopLoading();
                        return;
                    }
                    const decoder = new TextDecoder();
                    const reader = res.body.getReader();
                    const readChunk = async () => {
                        return reader.read().then(async ({value, done}) => {
                            if (!done) {
                                value = decoder.decode(value);
                                let chunks = value.split(/\n{2}/g);
                                chunks = chunks.filter(item => {
                                    return item.trim();
                                });
                                for (let i = 0; i < chunks.length; i++) {
                                    let chunk = chunks[i];
                                    if (chunk) {
                                        let payload;
                                        try {
                                            payload = JSON.parse(chunk).data;
                                        } catch (e) {
                                            break;
                                        }
                                        if (payload.choices[0].finish_reason) {
                                            let lenStop = payload.choices[0].finish_reason === "length";
                                            let longReplyFlag = enableLongReply && lenStop;
                                            if (!enableLongReply && lenStop) {currentResEle.children[1].children[0].className = "halfRefReq"}
                                            else {currentResEle.children[1].children[0].className = "refreshReq"};
                                            if (existVoice && enableAutoVoice && currentVoiceIdx === autoVoiceDataIdx) {
                                                let voiceText = longReplyFlag ? "" : progressData.slice(autoVoiceIdx), stop = !longReplyFlag;
                                                autoSpeechEvent(voiceText, currentResEle, false, stop);
                                            }
                                            break;
                                        } else {
                                            let content = "";
                                            if (payload.choices[0].message) {
                                                content = payload.choices[0].message.content
                                            } else if(payload.choices[0].delta) {
                                                content = payload.choices[0].delta.content
                                            }
                                            if (content) {
                                                if (!progressData && !content.trim()) continue;
                                                if (existVoice && enableAutoVoice && currentVoiceIdx === autoVoiceDataIdx) {
                                                    let spliter = content.match(/\.|\?|!|。|？|！|\n/);
                                                    if (spliter) {
                                                        let voiceText = progressData.slice(autoVoiceIdx) + content.slice(0, spliter.index + 1);
                                                        autoVoiceIdx += voiceText.length;
                                                        autoSpeechEvent(voiceText, currentResEle);
                                                    }
                                                }
                                                if (progressData) await delay();
                                                progressData = content;
                                                currentResEle.children[0].innerHTML = md.render(progressData);
                                                if (!isRefresh) {
                                                    scrollToBottom();
                                                }
                                            }
                                        }
                                    }
                                }
                                return readChunk();
                            } else {
                                if (isRefresh) {
                                    data[refreshIdx].content = progressData;
                                    if (longReplyFlag) return streamGen(true);
                                } else {
                                    if (long) {data[data.length - 1].content = progressData}
                                    else {data.push({role: "assistant", content: progressData})}
                                    if (longReplyFlag) return streamGen(true);
                                }
                                stopLoading(false);
                            }
                        });
                    };
                    await readChunk();
                } catch (e) {
                    if (e.message.indexOf("aborted") === -1) {
                        notyf.error("访问接口失败，请检查接口！")
                        stopLoading();
                    }
                }
            };
            const loadAction = (bool) => {
                loading = bool;
                sendBtnEle.disabled = bool;
                sendBtnEle.className = bool ? " loading" : "loaded";
                stopEle.style.display = bool ? "flex" : "none";
                textInputEvent();
            }
            const stopLoading = (abort = true) => {
                stopEle.style.display = "none";
                if (abort) {
                    controller.abort();
                    if (controllerId) clearTimeout(controllerId);
                    if (delayId) clearTimeout(delayId);
                    if (refreshIdx !== void 0) {data[refreshIdx].content = progressData}
                    else if (data[data.length - 1].role === "assistant") {data[data.length - 1].content = progressData}
                    else {data.push({role: "assistant", content: progressData})}
                    if (existVoice && enableAutoVoice && currentVoiceIdx === autoVoiceDataIdx && progressData.length) {
                        let voiceText = progressData.slice(autoVoiceIdx);
                        autoSpeechEvent(voiceText, currentResEle, false, true);
                    }
                }
                updateChats();
                controllerId = delayId = refreshIdx = void 0;
                autoVoiceIdx = 0;
                currentResEle.dataset.loading = false;
                currentResEle = null;
                progressData = "";
                loadAction(false);
            }
            const generateText = async (message) => {
                loadAction(true);
                let requestEle = createConvEle("request");
                requestEle.children[0].innerHTML = message;
                data.push({role: "user", content: message});
                if (chatsData[activeChatIdx].name === "新的会话") {
                    if (message.length > 50) {
                        message = message.slice(0, 47) + "...";
                    }
                    chatsData[activeChatIdx].name = message;
                    chatListEle.children[activeChatIdx].children[1].textContent = message;
                }
                updateChats();
                scrollToBottom();
                await streamGen();
            };
            textarea.onkeydown = (e) => {
                if (e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    genFunc();
                }
            };
            const genFunc = function () {
                if (recing) {
                    toggleRecEv();
                }
                let message = textarea.value.trim();
                if (message.length !== 0) {
                    if (loading === true) return;
                    textarea.value = "";
                    textarea.style.height = "47px";
                    generateText(message);
                }
            };
            sendBtnEle.onclick = genFunc;
            stopEle.onclick = stopLoading;
            document.getElementById("clearConv").onclick = () => {
                if (!loading && confirmAction("是否清空会话?")) {
                    endSpeak();
                    if (systemRole) {data.length = 1}
                    else {data.length = 0}
                    chatlog.innerHTML = "";
                    updateChats();
                }
            }

            </script>
            <link href="//cdn.staticfile.org/github-markdown-css/5.2.0/github-markdown-light.min.css" rel="stylesheet">
            <link href="//cdn.staticfile.org/highlight.js/11.7.0/styles/github.min.css" rel="stylesheet">
            <link href="//cdn.staticfile.org/KaTeX/0.16.4/katex.min.css" rel="stylesheet">
            <link href="//npm.elemecdn.com/markdown-it-texmath@1.0.0/css/texmath.css" rel="stylesheet">
            <script defer>
                const downRoleController = new AbortController();
                setTimeout(() => {
                    downRoleController.abort();
                }, 10000);
                const preEle = document.getElementById("preSetSystem");
                fetch("https://cdn.jsdelivr.net/gh/PlexPt/awesome-chatgpt-prompts-zh/prompts-zh.json", {
                    signal: downRoleController.signal
                }).then(async (response) => {
                    let res = await response.json();
                    for (let i = 0; i < res.length; i++) {
                        let key = "act" + i;
                        presetRoleData[key] = res[i].prompt.trim();
                        let optionEle = document.createElement("option");
                        optionEle.text = res[i].act;
                        optionEle.value = key;
                        preEle.options.add(optionEle);
                    }
                }).catch(e => { })
            </script>
</div>

