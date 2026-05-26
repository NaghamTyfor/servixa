<div class="secondary-nav">
    <div class="breadcrumbs-container" data-page-heading="Analytics">
        <!-- جعل header كمرجع للوضع المطلق -->
        <header class="header navbar navbar-expand-sm" style="position: relative !important; min-height: 52px;">

            <!-- الحاوية المراد وضعها في أقصى اليمين باستخدام position absolute -->
            <div class="d-flex" style="position: absolute !important; {{ session('locale') === 'ar' ? 'right' : 'left' }}: 0 !important; top: 50%; transform: translateY(-50%);">
                <a href="javascript:void(0);" class="btn-toggle sidebarCollapse" data-placement="bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6"  x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </a>

                <div class="d-flex breadcrumb-content">

                </div>
            </div>



        </header>
    </div>
</div>

<style>
    /* ==============================================
       شريط التنقل الثانوي - بنفسجي متوسط ناعم (Soft Purple)
       مع تأثيرات زجاجية وحركات ملفتة
       ============================================== */

    .secondary-nav,
    .secondary-nav .breadcrumbs-container,
    .secondary-nav header.header {
        background: rgba(156, 126, 210, 0.25) !important;
        /* بنفسجي متوسط ناعم (Soft Medium Purple) شفافية 25% */
        backdrop-filter: blur(10px) saturate(180%) !important;
        -webkit-backdrop-filter: blur(10px) saturate(180%) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.35) !important;
        border-radius: 0 0 20px 20px !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.2) !important;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1) !important;
    }

    /* تأثير عند تحميل الصفحة (حركة دخول خفيفة) */
    .secondary-nav {
        animation: softGlow 0.8s ease-out !important;
    }

    @keyframes softGlow {
        0% {
            opacity: 0;
            transform: translateY(-15px);
            backdrop-filter: blur(0px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
            backdrop-filter: blur(10px) saturate(180%);
        }
    }

    /* تأثير التمرير (hover) الملفت */
    .secondary-nav:hover,
    .secondary-nav:hover header.header {
        background: rgba(156, 126, 210, 0.4) !important;
        backdrop-filter: blur(15px) saturate(200%) !important;
        border-bottom-color: rgba(255, 255, 255, 0.6) !important;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.3) !important;
        transform: scaleY(1.02) !important;
    }

    /* زر التبديل (أيقونة القائمة) - تصميم ملفت */
    .secondary-nav .btn-toggle {
        background: rgba(255, 255, 255, 0.2) !important;
        border-radius: 16px !important;
        padding: 10px !important;
        margin: 0 8px !important;
        transition: all 0.3s cubic-bezier(0.34, 1.2, 0.64, 1) !important;
        cursor: pointer !important;
        backdrop-filter: blur(4px) !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
    }

    .secondary-nav .btn-toggle:hover {
        background: rgba(255, 255, 255, 0.45) !important;
        transform: rotate(90deg) scale(1.1) !important;
        box-shadow: 0 0 15px rgba(156, 126, 210, 0.6) !important;
        border-color: rgba(255, 255, 255, 0.8) !important;
    }

    /* أيقونة القائمة */
    .secondary-nav .btn-toggle svg.feather-menu {
        stroke: #4a2c7a !important; /* بنفسجي غامق ناعم */
        transition: stroke 0.2s ease, filter 0.2s ease !important;
        filter: drop-shadow(0 2px 2px rgba(0,0,0,0.1)) !important;
    }

    .secondary-nav .btn-toggle:hover svg.feather-menu {
        stroke: #2d1b4e !important;
        filter: drop-shadow(0 0 5px rgba(156, 126, 210, 0.8)) !important;
    }

    /* أي محتوى نصي داخل breadcrumb */
    .secondary-nav .breadcrumb-content {
        color: #2d1b4e !important;
        font-weight: 500 !important;
        text-shadow: 0 1px 1px rgba(255,255,255,0.3) !important;
        transition: letter-spacing 0.2s ease !important;
    }

    .secondary-nav:hover .breadcrumb-content {
        letter-spacing: 0.5px !important;
    }

    /* تأثير وميض ناعم متكرر (اختياري: يلفت الانتباه بلطف) */
    .secondary-nav {
        animation: subtlePulse 3s infinite !important;
    }

    @keyframes subtlePulse {
        0% {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
        50% {
            box-shadow: 0 8px 25px rgba(156, 126, 210, 0.25), inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        100% {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }
    }
</style>
