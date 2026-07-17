<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale()); ?>" dir="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>" data-theme="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo $__env->yieldContent('title', 'DARI'); ?> - نظام داري لإدارة العقارات</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
<!-- DataTables -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
<!-- SweetAlert2 -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<!-- تخصيص SweetAlert2 - أصغر وأكثر احترافية -->
<style>
.swal2-popup.swal2-modal {
font-size: 14px !important;
padding: 20px !important;
width: 300px !important;
border-radius: 12px !important;
}
.swal2-popup .swal2-title {
font-size: 16px !important;
padding: 0 !important;
margin-bottom: 5px !important;
}
.swal2-popup .swal2-html-container {
font-size: 13px !important;
margin: 8px 0 !important;
}
.swal2-popup .swal2-html-container p {
margin: 0 !important;
font-size: 13px !important;
}
.swal2-popup .swal2-icon {
width: 45px !important;
height: 45px !important;
margin: 8px auto !important;
border-width: 3px !important;
}
.swal2-popup .swal2-icon .swal2-icon-content {
font-size: 28px !important;
}
.swal2-popup .swal2-icon.swal2-question::before,
.swal2-popup .swal2-icon.swal2-warning::before {
font-size: 28px !important;
}
.swal2-popup .swal2-actions {
margin-top: 12px !important;
gap: 8px !important;
}
.swal2-popup .swal2-confirm, .swal2-popup .swal2-cancel {
padding: 7px 18px !important;
font-size: 12px !important;
border-radius: 6px !important;
font-weight: 500 !important;
}
</style>
<style>
:root {
--bg-color: #f5f7fa;
--sidebar-bg: #3D4F5F;
--accent: #C4A574;
--accent-dark: #B8956E;
--card-bg: #fff;
--text-color: #333;
--text-muted: #6c757d;
--border-color: #dee2e6;
}
[data-theme="dark"] {
--bg-color: #1a1a2e;
--sidebar-bg: #2D3A47;
--accent: #C4A574;
--accent-dark: #B8956E;
--card-bg: #16213e;
--text-color: #eee;
--text-muted: #adb5bd;
--border-color: #2a4a6f;
}
* { font-family: 'Tajawal', sans-serif; }
body { background: var(--bg-color); color: var(--text-color); margin: 0; min-height: 100vh; }

/* Sidebar */
.sidebar {
background: var(--sidebar-bg);
height: 100vh;
width: 260px;
position: fixed;
right: 0;
top: 0;
z-index: 1000;
transition: transform 0.3s ease;
overflow-y: auto;
}
.sidebar.hidden { transform: translateX(100%); }
.sidebar .nav-link {
color: rgba(255,255,255,0.8);
padding: 12px 20px;
border-radius: 8px;
margin: 4px 10px;
display: flex;
align-items: center;
gap: 10px;
transition: all 0.2s;
}
.sidebar .nav-link:hover, .sidebar .nav-link.active {
background: rgba(255,255,255,0.15);
color: #fff;
}
.sidebar-logo { width: 100px; height: auto; border-radius: 12px; background: #fff; padding: 8px; }
.nav-section { color: rgba(255,255,255,0.5); font-size: 0.75rem; padding: 15px 20px 5px; text-transform: uppercase; }
.sidebar-bottom { padding: 15px 10px 30px; border-top: 1px solid rgba(255,255,255,0.1); }
.close-sidebar {
position: absolute;
top: 15px;
left: 15px;
background: rgba(255,255,255,0.2);
border: none;
color: #fff;
font-size: 1.3rem;
cursor: pointer;
padding: 8px 12px;
border-radius: 8px;
}
.close-sidebar:hover { background: rgba(255,255,255,0.3); }

/* Main Content */
.main-content {
margin-right: 260px;
min-height: 100vh;
transition: margin 0.3s ease;
}
.main-content.expanded { margin-right: 0; }

/* Menu Toggle */
.menu-toggle { display: none; }
.menu-toggle-inline { background: rgba(255,255,255,0.2); color: #fff; border: none; width: 36px; height: 36px; border-radius: 8px; font-size: 1.2rem; cursor: pointer; display: none; align-items: center; justify-content: center; }
.menu-toggle-inline:hover { background: rgba(255,255,255,0.3); }

/* Top Bar */
.top-bar { 
background: var(--sidebar-bg); 
padding: 10px 20px; 
border-radius: 0; 
margin-bottom: 15px; 
color: #fff;
display: flex;
align-items: center;
gap: 12px;
}
.top-bar-icon { 
background: rgba(255,255,255,0.15); 
border: none; 
color: var(--accent); 
width: 38px; 
height: 38px; 
border-radius: 50%; 
display: flex; 
align-items: center; 
justify-content: center; 
cursor: pointer; 
transition: all 0.2s;
font-size: 1.1rem;
text-decoration: none;
}
.top-bar-icon:hover { background: rgba(255,255,255,0.25); color: #fff; }
.avatar-circle { 
width: 40px; 
height: 40px; 
border-radius: 50%; 
background: var(--accent); 
display: flex; 
align-items: center; 
justify-content: center; 
color: #fff; 
font-weight: bold; 
cursor: pointer;
}

/* البحث الجديد */
.search-wrapper {
flex: 1;
max-width: 400px;
position: relative;
}
.search-box {
display: flex;
align-items: center;
background: rgba(255,255,255,0.1);
border-radius: 10px;
padding: 4px 10px;
border: 2px solid transparent;
transition: all 0.3s;
}
.search-box:focus-within {
border-color: var(--accent);
background: rgba(255,255,255,0.15);
}
.search-input {
flex: 1;
padding: 10px 12px;
border: none;
background: transparent;
color: #fff;
font-size: 14px;
}
.search-input::placeholder { color: rgba(255,255,255,0.5); }
.search-input:focus { outline: none; }

.mic-btn {
width: 36px;
height: 36px;
border-radius: 8px;
border: none;
background: transparent;
cursor: pointer;
transition: all 0.3s;
display: flex;
align-items: center;
justify-content: center;
}
.mic-btn:hover { transform: scale(1.1); }
.mic-btn.listening {
animation: pulse 1s infinite;
}
@keyframes pulse {
0%, 100% { opacity: 1; }
50% { opacity: 0.5; }
}

/* القائمة المنسدلة للبحث */
.search-dropdown {
position: absolute;
top: 100%;
right: 0;
left: 0;
background: var(--card-bg);
border-radius: 12px;
box-shadow: 0 10px 40px rgba(0,0,0,0.2);
margin-top: 10px;
padding: 15px;
display: none;
z-index: 100;
}
.search-dropdown.show { display: block; }

.filter-label {
font-size: 12px;
font-weight: 700;
color: var(--text-muted);
margin-bottom: 10px;
}
.filter-chips {
display: flex;
flex-wrap: wrap;
gap: 8px;
}
.chip {
padding: 6px 14px;
background: var(--bg-color);
border: 1px solid var(--border-color);
border-radius: 20px;
font-size: 12px;
cursor: pointer;
transition: all 0.2s;
color: var(--text-color);
}
.chip:hover { border-color: var(--accent); background: rgba(196, 165, 116, 0.1); }
.chip.active { background: var(--accent); color: #fff; border-color: var(--accent); }

.spacer { flex: 1; }

/* Messages Icon */
.msg-icon { position: relative; cursor: pointer; }
.msg-badge {
position: absolute;
top: -5px;
right: -5px;
background: #dc3545;
color: #fff;
border-radius: 50%;
width: 18px;
height: 18px;
font-size: 0.65rem;
display: flex;
align-items: center;
justify-content: center;
}

/* ========================================
   شارات الإشعارات والرسائل التفاعلية
======================================== */
.notif-badge {
position: absolute;
top: -5px;
right: -5px;
min-width: 20px;
height: 20px;
padding: 0 5px;
border-radius: 50%;
font-size: 11px;
font-weight: bold;
display: flex;
align-items: center;
justify-content: center;
color: #fff;
animation: badgePulse 2s infinite;
border: 2px solid var(--sidebar-bg);
}
.notif-badge-red {
background: linear-gradient(135deg, #dc3545, #c82333);
box-shadow: 0 2px 8px rgba(220, 53, 69, 0.5);
}
.notif-badge-blue {
background: linear-gradient(135deg, #0d6efd, #0b5ed7);
box-shadow: 0 2px 8px rgba(13, 110, 253, 0.5);
}
@keyframes badgePulse {
0%, 100% { transform: scale(1); }
50% { transform: scale(1.1); }
}

/* القوائم المنسدلة للإشعارات والرسائل */
.dropdown-menu-custom {
position: absolute;
top: 50px;
left: 0;
width: 340px;
background: var(--card-bg);
border-radius: 12px;
box-shadow: 0 10px 40px rgba(0,0,0,0.25);
z-index: 1050;
display: none;
overflow: hidden;
}
.dropdown-menu-custom.show { display: block; }

.dropdown-header {
padding: 12px 15px;
background: var(--sidebar-bg);
color: #fff;
display: flex;
justify-content: space-between;
align-items: center;
font-weight: 600;
font-size: 14px;
}
.dropdown-header .mark-all-read {
background: rgba(255,255,255,0.2);
border: none;
color: #fff;
padding: 4px 10px;
border-radius: 15px;
font-size: 11px;
cursor: pointer;
transition: all 0.2s;
}
.dropdown-header .mark-all-read:hover { background: rgba(255,255,255,0.3); }

.dropdown-body {
max-height: 320px;
overflow-y: auto;
}
.dropdown-item-custom {
padding: 12px 15px;
border-bottom: 1px solid var(--border-color);
cursor: pointer;
transition: background 0.2s;
display: flex;
gap: 12px;
align-items: flex-start;
text-decoration: none;
color: var(--text-color);
}
.dropdown-item-custom:hover { background: var(--bg-color); }
.dropdown-item-custom.unread { 
background: rgba(13, 110, 253, 0.05); 
border-right: 3px solid var(--accent);
}
.dropdown-item-custom .item-icon {
width: 42px;
height: 42px;
border-radius: 50%;
display: flex;
align-items: center;
justify-content: center;
font-size: 1.1rem;
flex-shrink: 0;
}
.dropdown-item-custom .item-icon.notif { background: #fee2e2; color: #dc3545; }
.dropdown-item-custom .item-icon.msg { background: #dbeafe; color: #0d6efd; }
.dropdown-item-custom .item-icon.success { background: #d1fae5; color: #059669; }
.dropdown-item-custom .item-icon.warning { background: #fef3c7; color: #d97706; }
.dropdown-item-custom .item-icon.info { background: #e0e7ff; color: #4f46e5; }
.dropdown-item-custom .item-content { flex: 1; min-width: 0; }
.dropdown-item-custom .item-title { 
font-weight: 600; 
font-size: 13px; 
margin-bottom: 3px; 
color: var(--text-color); 
white-space: nowrap;
overflow: hidden;
text-overflow: ellipsis;
}
.dropdown-item-custom .item-text { 
font-size: 12px; 
color: var(--text-muted); 
white-space: nowrap; 
overflow: hidden; 
text-overflow: ellipsis;
margin-bottom: 3px;
}
.dropdown-item-custom .item-time { 
font-size: 11px; 
color: var(--text-muted);
display: flex;
align-items: center;
gap: 5px;
}

.dropdown-footer {
padding: 12px 15px;
text-align: center;
border-top: 1px solid var(--border-color);
background: var(--bg-color);
}
.dropdown-footer a {
color: var(--accent);
text-decoration: none;
font-size: 13px;
font-weight: 600;
}
.dropdown-footer a:hover { text-decoration: underline; }

/* حالة فارغة */
.empty-state {
padding: 30px 15px;
text-align: center;
color: var(--text-muted);
}
.empty-state i {
font-size: 2.5rem;
margin-bottom: 10px;
opacity: 0.5;
}
.empty-state p {
margin: 0;
font-size: 13px;
}

/* Loading Spinner */
.spin { animation: spin 1s linear infinite; display: inline-block; }
@keyframes spin { 100% { transform: rotate(360deg); } }

/* Cards */
.card {
background: var(--card-bg);
border: none;
border-radius: 15px;
box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}
.stat-card {
padding: 25px;
text-align: center;
cursor: pointer;
transition: transform 0.2s;
}
.stat-card:hover { transform: translateY(-5px); }

/* Badges */
.badge-admin { background: linear-gradient(135deg, #667eea, #764ba2); }
.badge-owner { background: linear-gradient(135deg, #00b894, #00cec9); }
.badge-resident { background: #6c5ce7; }
.role-badge { color: #fff; padding: 8px 18px; border-radius: 25px; }

/* Theme Toggle */
.btn-theme {
background: none;
border: none;
font-size: 1.4rem;
cursor: pointer;
color: var(--text-color);
}

/* Forms */
.form-control, .form-select {
background: var(--card-bg);
border-color: var(--border-color);
color: var(--text-color);
}
.form-control:focus, .form-select:focus {
background: var(--card-bg);
border-color: #667eea;
color: var(--text-color);
box-shadow: 0 0 0 3px rgba(102,126,234,0.2);
}

/* Tables */
.table { color: var(--text-color); }
.table th { background: var(--bg-color); border-color: var(--border-color); }
.table td { border-color: var(--border-color); }

/* Modal */
.modal-content { background: var(--card-bg); color: var(--text-color); }

/* Toast Notification - الذهبي */
.dari-toast {
position: fixed;
top: 20px;
left: 20px;
z-index: 9999;
padding: 14px 22px;
border-radius: 10px;
color: #fff;
font-size: 14px;
display: flex;
align-items: center;
gap: 12px;
box-shadow: 0 8px 25px rgba(0,0,0,0.25);
animation: toastSlideIn 0.4s ease;
background: linear-gradient(135deg, #B8860B, #DAA520);
}
.dari-toast.error {
background: linear-gradient(135deg, #dc3545, #c82333);
}
.dari-toast.warning {
background: linear-gradient(135deg, #fd7e14, #e8590c);
}
@keyframes toastSlideIn {
from { transform: translateX(-120%); opacity: 0; }
to { transform: translateX(0); opacity: 1; }
}
@keyframes toastSlideOut {
from { transform: translateX(0); opacity: 1; }
to { transform: translateX(-120%); opacity: 0; }
}

/* Responsive */
@media (max-width: 991.98px) {
.sidebar { transform: translateX(100%); }
.sidebar.show { transform: translateX(0); }
.main-content { margin-right: 0; }
.menu-toggle-inline { display: flex; }
.search-wrapper { max-width: 250px; }
}
@media (max-width: 576px) {
.search-wrapper { max-width: 150px; }
.user-name-text { display: none !important; }
.dropdown-menu-custom {
    width: 300px;
    left: -120px;
}
}
</style>
<?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
<button class="close-sidebar" onclick="closeSidebar()">
<i class="bi bi-x-lg"></i>
</button>

<div class="text-center py-4 mt-3">
<img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="DARI" class="sidebar-logo" onerror="this.src='https://via.placeholder.com/100x60/667eea/fff?text=DARI'">
</div>

<nav class="nav flex-column">
<a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard*') ? 'active' : ''); ?>">
<i class="bi bi-speedometer2"></i>
<span><?php echo e(__('messages.dashboard')); ?></span>
</a>




<?php if(auth()->user()->hasRole('Admin')): ?>
<div class="nav-section"><?php echo e(__('messages.system_management')); ?></div>

<a href="<?php echo e(route('users.index')); ?>" class="nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
<i class="bi bi-people"></i>
<span><?php echo e(__('messages.users')); ?></span>
</a>

<a href="<?php echo e(route('buildings.index')); ?>" class="nav-link <?php echo e(request()->routeIs('buildings.*') ? 'active' : ''); ?>">
<i class="bi bi-building"></i>
<span><?php echo e(__('messages.buildings')); ?></span>
</a>

<a href="<?php echo e(route('units.index')); ?>" class="nav-link <?php echo e(request()->routeIs('units.*') ? 'active' : ''); ?>">
<i class="bi bi-door-open"></i>
<span><?php echo e(__('messages.units')); ?></span>
</a>

<a href="<?php echo e(route('contracts.index')); ?>" class="nav-link <?php echo e(request()->routeIs('contracts.*') ? 'active' : ''); ?>">
<i class="bi bi-file-earmark-text"></i>
<span><?php echo e(__('messages.contracts')); ?></span>
</a>

<a href="<?php echo e(route('payments.index')); ?>" class="nav-link <?php echo e(request()->routeIs('payments.*') ? 'active' : ''); ?>">
<i class="bi bi-cash-stack"></i>
<span><?php echo e(__('messages.payments')); ?></span>
</a>

<a href="<?php echo e(route('reports.index')); ?>" class="nav-link <?php echo e(request()->routeIs('reports.*') ? 'active' : ''); ?>">
<i class="bi bi-bar-chart"></i>
<span><?php echo e(__('messages.reports')); ?></span>
</a>

<a href="<?php echo e(route('settings.index')); ?>" class="nav-link <?php echo e(request()->routeIs('settings.*') ? 'active' : ''); ?>">
<i class="bi bi-gear"></i>
<span><?php echo e(__('messages.settings')); ?></span>
</a>
<?php endif; ?>




<?php if(auth()->user()->hasRole('Manager')): ?>
<div class="nav-section"><?php echo e(__('messages.building_management')); ?></div>

<a href="<?php echo e(route('buildings.index')); ?>" class="nav-link <?php echo e(request()->routeIs('buildings.*') ? 'active' : ''); ?>">
<i class="bi bi-building"></i>
<span><?php echo e(__('messages.buildings')); ?></span>
</a>

<a href="<?php echo e(route('units.index')); ?>" class="nav-link <?php echo e(request()->routeIs('units.*') ? 'active' : ''); ?>">
<i class="bi bi-door-open"></i>
<span><?php echo e(__('messages.my_unit')); ?></span>
</a>

<a href="<?php echo e(route('users.index')); ?>" class="nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
<i class="bi bi-people"></i>
<span><?php echo e(__('messages.residents')); ?></span>
</a>

<a href="<?php echo e(route('contracts.index')); ?>" class="nav-link <?php echo e(request()->routeIs('contracts.*') ? 'active' : ''); ?>">
<i class="bi bi-file-earmark-text"></i>
<span><?php echo e(__('messages.contracts')); ?></span>
</a>

<a href="<?php echo e(route('maintenance.index')); ?>" class="nav-link <?php echo e(request()->routeIs('maintenance.*') ? 'active' : ''); ?>">
<i class="bi bi-tools"></i>
<span><?php echo e(__('messages.maintenance_requests')); ?></span>
</a>

<a href="<?php echo e(route('manager.unit-requests')); ?>" class="nav-link <?php echo e(request()->routeIs('manager.unit-requests') ? 'active' : ''); ?>">
<i class="bi bi-house-add"></i>
<span>طلبات الوحدات</span>
</a>



<a href="<?php echo e(route('payments.index')); ?>" class="nav-link <?php echo e(request()->routeIs('payments.*') ? 'active' : ''); ?>">
<i class="bi bi-cash-stack"></i>
<span><?php echo e(__('messages.payments')); ?></span>
</a>

<a href="<?php echo e(route('reports.index')); ?>" class="nav-link <?php echo e(request()->routeIs('reports.*') ? 'active' : ''); ?>">
<i class="bi bi-bar-chart"></i>
<span><?php echo e(__('messages.reports')); ?></span>
</a>

<a href="<?php echo e(route('user-settings.index')); ?>" class="nav-link <?php echo e(request()->routeIs('user-settings.*') ? 'active' : ''); ?>">
<i class="bi bi-gear"></i>
<span>الإعدادات</span>
</a>
<?php endif; ?>




<?php if(auth()->user()->hasRole('Resident')): ?>
<div class="nav-section"><?php echo e(__('messages.my_services')); ?></div>

<a href="<?php echo e(route('resident.my-unit')); ?>" class="nav-link <?php echo e(request()->routeIs('resident.my-unit') ? 'active' : ''); ?>">
<i class="bi bi-door-open"></i>
<span>وحدتي</span>
</a>

<a href="<?php echo e(route('resident.my-maintenance')); ?>" class="nav-link <?php echo e(request()->routeIs('resident.my-maintenance') ? 'active' : ''); ?>">
<i class="bi bi-tools"></i>
<span><?php echo e(__('messages.maintenance_requests')); ?></span>
</a>

<a href="<?php echo e(route('resident.my-invoices')); ?>" class="nav-link <?php echo e(request()->routeIs('resident.my-invoices') ? 'active' : ''); ?>">
<i class="bi bi-receipt"></i>
<span><?php echo e(__('messages.my_invoices')); ?></span>
</a>

<a href="<?php echo e(route('resident.pay-online')); ?>" class="nav-link <?php echo e(request()->routeIs('resident.pay-online') ? 'active' : ''); ?>">
<i class="bi bi-wallet2"></i>
<span><?php echo e(__('messages.pay_online')); ?></span>
</a>

<a href="<?php echo e(route('resident.my-complaints')); ?>" class="nav-link <?php echo e(request()->routeIs('resident.my-complaints') ? 'active' : ''); ?>">
<i class="bi bi-chat-dots"></i>
<span><?php echo e(__('messages.my_complaints')); ?></span>
</a>

<a href="<?php echo e(route('resident.request-unit')); ?>" class="nav-link <?php echo e(request()->routeIs('resident.request-unit') ? 'active' : ''); ?>">
<i class="bi bi-house-add"></i>
<span>طلب وحدة</span>
</a>

<a href="<?php echo e(route('resident.my-requests')); ?>" class="nav-link <?php echo e(request()->routeIs('resident.my-requests') ? 'active' : ''); ?>">
<i class="bi bi-list-check"></i>
<span>طلباتي</span>
</a>

<a href="<?php echo e(route('user-settings.index')); ?>" class="nav-link <?php echo e(request()->routeIs('user-settings.*') ? 'active' : ''); ?>">
<i class="bi bi-gear"></i>
<span>الإعدادات</span>
</a>
<?php endif; ?>




<div class="nav-section"><?php echo e(__('messages.communication')); ?></div>

<a href="<?php echo e(route('messages.index')); ?>" class="nav-link <?php echo e(request()->routeIs('messages.*') ? 'active' : ''); ?>">
<i class="bi bi-envelope"></i>
<span><?php echo e(__('messages.messages')); ?></span>
<?php
$sidebarUnreadMsgCount = auth()->user()->unreadMessages()->count();
?>
<?php if($sidebarUnreadMsgCount > 0): ?>
<span class="badge bg-danger rounded-pill ms-auto"><?php echo e($sidebarUnreadMsgCount); ?></span>
<?php endif; ?>
</a>

<a href="<?php echo e(route('notifications.index')); ?>" class="nav-link <?php echo e(request()->routeIs('notifications.*') ? 'active' : ''); ?>">
<i class="bi bi-bell"></i>
<span><?php echo e(__('messages.notifications')); ?></span>
<?php
$sidebarUnreadNotifCount = auth()->user()->unreadNotifications()->count();
?>
<?php if($sidebarUnreadNotifCount > 0): ?>
<span class="badge bg-danger rounded-pill ms-auto"><?php echo e($sidebarUnreadNotifCount); ?></span>
<?php endif; ?>
</a>

<a href="<?php echo e(route('announcements.index')); ?>" class="nav-link <?php echo e(request()->routeIs('announcements.*') ? 'active' : ''); ?>">
<i class="bi bi-megaphone"></i>
<span><?php echo e(__('messages.announcements')); ?></span>
</a>

</nav>
<div class="sidebar-bottom">
<a href="<?php echo e(route('profile')); ?>" class="nav-link <?php echo e(request()->routeIs('profile') ? 'active' : ''); ?>">
<i class="bi bi-person-circle"></i>
<span><?php echo e(__('messages.profile')); ?></span>
</a>
<form action="<?php echo e(route('logout')); ?>" method="POST" id="logoutForm">
<?php echo csrf_field(); ?>
<button type="button" onclick="confirmLogout('logoutForm')" class="nav-link border-0 bg-transparent w-100 text-start text-danger">
<i class="bi bi-box-arrow-right"></i>
<span><?php echo e(__('messages.logout')); ?></span>
</button>
</form>
</div>
</aside>

<!-- Main Content -->
<div class="main-content" id="mainContent">
<!-- Top Bar الجديد -->
<div class="top-bar">
<!-- يمين: زر القائمة + الصورة + الاسم -->
<button class="menu-toggle-inline" onclick="openSidebar()"><i class="bi bi-list"></i></button>
<?php if(auth()->user()->avatar): ?>
<img src="<?php echo e(asset('storage/' . auth()->user()->avatar)); ?>" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;cursor:pointer;" onclick="window.location='<?php echo e(route('profile')); ?>'">
<?php else: ?>
<div class="avatar-circle" onclick="window.location='<?php echo e(route('profile')); ?>'"><?php echo e(mb_substr(auth()->user()->name ?? 'م', 0, 1)); ?></div>
<?php endif; ?>
<span class="user-name-text d-none d-md-inline" style="font-size: 0.95rem;"><?php echo e(__('messages.welcome')); ?> <?php echo e(auth()->user()->name ?? ''); ?></span>

<div class="spacer"></div>

<!-- وسط: البحث مع الميكروفون -->
<div class="search-wrapper">
<div class="search-box" id="searchBox">
<input type="text" class="search-input" placeholder="بحث في النظام..." id="globalSearch" onfocus="showSearchDropdown()">
<button class="mic-btn" id="micBtn" onclick="startVoiceSearch()" title="البحث الصوتي">
<svg width="20" height="20" viewBox="0 0 24 24">
<path fill="#4285f4" d="M12 14c1.66 0 3-1.34 3-3V5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z"/>
<path fill="#ea4335" d="M12 14c1.66 0 3-1.34 3-3V9H9v2c0 1.66 1.34 3 3 3z"/>
<path fill="#4285f4" d="M17 11c0 2.76-2.24 5-5 5s-5-2.24-5-5H5c0 3.53 2.61 6.43 6 6.92V21h2v-3.08c3.39-.49 6-3.39 6-6.92h-2z"/>
</svg>
</button>
</div>

<!-- القائمة المنسدلة للفلاتر -->
<div class="search-dropdown" id="searchDropdown">
<div class="filter-label">فلترة حسب:</div>
<div class="filter-chips">
<?php if(auth()->user()->hasRole('Admin')): ?>
<div class="chip active" data-filter="all">الكل</div>
<div class="chip" data-filter="buildings">المباني</div>
<div class="chip" data-filter="units">الوحدات</div>
<div class="chip" data-filter="users">المستخدمين</div>
<div class="chip" data-filter="contracts">العقود</div>
<div class="chip" data-filter="invoices">الفواتير</div>
<div class="chip" data-filter="payments">المدفوعات</div>
<div class="chip" data-filter="maintenance">الصيانة</div>
<div class="chip" data-filter="complaints">الشكاوى</div>
<div class="chip" data-filter="settings">الإعدادات</div>
<?php elseif(auth()->user()->hasRole('Manager')): ?>
<div class="chip active" data-filter="all">الكل</div>
<div class="chip" data-filter="buildings">مبانيي</div>
<div class="chip" data-filter="units">وحداتي</div>
<div class="chip" data-filter="residents">السكان</div>
<div class="chip" data-filter="contracts">العقود</div>
<div class="chip" data-filter="invoices">الفواتير</div>
<div class="chip" data-filter="maintenance">الصيانة</div>
<div class="chip" data-filter="complaints">الشكاوى</div>
<?php else: ?>
<div class="chip active" data-filter="all">الكل</div>
<div class="chip" data-filter="invoices">فواتيري</div>
<div class="chip" data-filter="payments">مدفوعاتي</div>
<div class="chip" data-filter="maintenance">طلبات الصيانة</div>
<div class="chip" data-filter="complaints">شكاواي</div>
<div class="chip" data-filter="announcements">الإعلانات</div>
<?php endif; ?>
</div>
</div>
</div>

<div class="spacer"></div>

<!-- يسار: الأيقونات التفاعلية -->
<div class="d-flex align-items-center gap-2">
    <!-- تغيير اللغة -->
    <a href="<?php echo e(route('lang.switch', app()->getLocale() == 'ar' ? 'en' : 'ar')); ?>" class="top-bar-icon" title="<?php echo e(app()->getLocale() == 'ar' ? 'English' : 'العربية'); ?>">
        <i class="bi bi-translate"></i>
    </a>
    
    <!-- الإشعارات - شارة حمراء -->
    <?php
        $unreadNotifCount = auth()->user()->unreadNotifications()->count();
    ?>
    <div class="position-relative notification-wrapper">
        <button class="top-bar-icon" onclick="toggleNotifications()" title="الإشعارات">
            <i class="bi bi-bell-fill"></i>
        </button>
        <?php if($unreadNotifCount > 0): ?>
        <span class="notif-badge notif-badge-red"><?php echo e($unreadNotifCount > 99 ? '99+' : $unreadNotifCount); ?></span>
        <?php endif; ?>
        
        <!-- قائمة الإشعارات المنسدلة -->
        <div class="dropdown-menu-custom notifications-dropdown" id="notificationsDropdown">
            <div class="dropdown-header">
                <span><i class="bi bi-bell me-2"></i>الإشعارات</span>
                <?php if($unreadNotifCount > 0): ?>
                <button class="mark-all-read" onclick="markAllNotificationsRead()">تحديد الكل كمقروء</button>
                <?php endif; ?>
            </div>
            <div class="dropdown-body" id="notificationsList">
                <div class="text-center py-3"><i class="bi bi-arrow-repeat spin"></i> جاري التحميل...</div>
            </div>
            <div class="dropdown-footer">
                <a href="<?php echo e(route('notifications.index')); ?>">عرض جميع الإشعارات</a>
            </div>
        </div>
    </div>
    
    <!-- الرسائل - شارة زرقاء -->
    <?php
        $unreadMsgCount = auth()->user()->unreadMessages()->count();
    ?>
    <div class="position-relative message-wrapper">
        <button class="top-bar-icon" onclick="toggleMessages()" title="الرسائل">
            <i class="bi bi-envelope-fill"></i>
        </button>
        <?php if($unreadMsgCount > 0): ?>
        <span class="notif-badge notif-badge-blue"><?php echo e($unreadMsgCount > 99 ? '99+' : $unreadMsgCount); ?></span>
        <?php endif; ?>
        
        <!-- قائمة الرسائل المنسدلة -->
        <div class="dropdown-menu-custom messages-dropdown" id="messagesDropdown">
            <div class="dropdown-header">
                <span><i class="bi bi-envelope me-2"></i>الرسائل</span>
                <?php if($unreadMsgCount > 0): ?>
                <button class="mark-all-read" onclick="markAllMessagesRead()">تحديد الكل كمقروء</button>
                <?php endif; ?>
            </div>
            <div class="dropdown-body" id="messagesList">
                <div class="text-center py-3"><i class="bi bi-arrow-repeat spin"></i> جاري التحميل...</div>
            </div>
            <div class="dropdown-footer">
                <a href="<?php echo e(route('messages.index')); ?>">عرض جميع الرسائل</a>
            </div>
        </div>
    </div>
    
    <!-- الوضع الليلي -->
    <button class="top-bar-icon" onclick="toggleTheme()" title="الوضع الليلي">
        <i class="bi bi-moon-fill" id="themeIcon"></i>
    </button>
</div>
</div>

<!-- Page Content -->
<div class="p-4">

<?php if(session('success')): ?>
<div class="dari-toast" id="dariToast">
<svg width="22" height="22" fill="currentColor" viewBox="0 0 20 20">
<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
</svg>
<span><?php echo e(session('success')); ?></span>
</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="dari-toast error" id="dariToast">
<svg width="22" height="22" fill="currentColor" viewBox="0 0 20 20">
<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
</svg>
<span><?php echo e(session('error')); ?></span>
</div>
<?php endif; ?>

<?php if(session('warning')): ?>
<div class="dari-toast warning" id="dariToast">
<svg width="22" height="22" fill="currentColor" viewBox="0 0 20 20">
<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
</svg>
<span><?php echo e(session('warning')); ?></span>
</div>
<?php endif; ?>

<?php if($errors->any()): ?>
<div class="dari-toast error" id="dariToast">
<svg width="22" height="22" fill="currentColor" viewBox="0 0 20 20">
<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
</svg>
<span><?php echo e($errors->first()); ?></span>
</div>
<?php endif; ?>

<?php echo $__env->yieldContent('content'); ?>
</div>
</div>

<!-- Messages Modal -->
<div class="modal fade" id="messagesModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title">
<i class="bi bi-envelope me-2"></i>
<?php if(auth()->user()->hasRole('Admin')): ?>
رسائل مالكي المباني
<?php elseif(auth()->user()->hasRole('Manager')): ?>
رسائل السكان
<?php else: ?>
الرسائل
<?php endif; ?>
</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<div class="p-3 bg-light rounded mb-2">
<strong>أحمد محمد</strong>
<p class="small text-muted mb-0">طلب صيانة عاجلة</p>
<small class="text-muted">منذ 10 دقائق</small>
</div>
<div class="p-3 bg-light rounded mb-2">
<strong>سارة علي</strong>
<p class="small text-muted mb-0">استفسار عن الفاتورة</p>
<small class="text-muted">منذ ساعة</small>
</div>
<div class="p-3 bg-light rounded">
<strong>خالد محمود</strong>
<p class="small text-muted mb-0">طلب تجديد العقد</p>
<small class="text-muted">منذ يومين</small>
</div>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Sidebar Toggle
function openSidebar() {
document.getElementById('sidebar').classList.remove('hidden');
document.getElementById('sidebar').classList.add('show');
document.getElementById('mainContent').classList.remove('expanded');
document.querySelector('.menu-toggle-inline').style.display = 'none';
}

function closeSidebar() {
document.getElementById('sidebar').classList.add('hidden');
document.getElementById('sidebar').classList.remove('show');
document.getElementById('mainContent').classList.add('expanded');
document.querySelector('.menu-toggle-inline').style.display = 'flex';
}

// Theme Toggle
function toggleTheme() {
const html = document.documentElement;
const currentTheme = html.getAttribute('data-theme');
const newTheme = currentTheme === 'light' ? 'dark' : 'light';
html.setAttribute('data-theme', newTheme);
localStorage.setItem('theme', newTheme);
updateIcon(newTheme);
}

function updateIcon(theme) {
document.getElementById('themeIcon').className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-fill';
}

// Search Dropdown
function showSearchDropdown() {
document.getElementById('searchDropdown').classList.add('show');
}

// إخفاء القائمة عند الضغط خارجها
document.addEventListener('click', function(e) {
if (!e.target.closest('.search-wrapper')) {
document.getElementById('searchDropdown').classList.remove('show');
}
});

// تفعيل الفلاتر
document.querySelectorAll('.chip').forEach(chip => {
chip.addEventListener('click', function(e) {
e.stopPropagation();
document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
this.classList.add('active');
});
});

// البحث الصوتي
function startVoiceSearch() {
const micBtn = document.getElementById('micBtn');

if ('webkitSpeechRecognition' in window || 'SpeechRecognition' in window) {
const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
const recognition = new SpeechRecognition();
recognition.lang = 'ar-SA';
recognition.continuous = false;
recognition.interimResults = false;

// بدء الاستماع
micBtn.classList.add('listening');
recognition.start();

// عند الحصول على نتيجة
recognition.onresult = function(event) {
const transcript = event.results[0][0].transcript;
document.getElementById('globalSearch').value = transcript;
micBtn.classList.remove('listening');

// إظهار رسالة نجاح
Swal.fire({
icon: 'success',
title: 'تم التعرف على الصوت',
text: transcript,
timer: 2000,
showConfirmButton: false
}).then(() => {
performSearch(transcript);
});
};

// عند انتهاء الاستماع
recognition.onend = function() {
micBtn.classList.remove('listening');
};

// عند حدوث خطأ
recognition.onerror = function(event) {
micBtn.classList.remove('listening');
let errorMessage = 'حدث خطأ في التعرف على الصوت';

if (event.error === 'no-speech') {
errorMessage = 'لم يتم اكتشاف صوت، حاول مرة أخرى';
} else if (event.error === 'not-allowed') {
errorMessage = 'يرجى السماح بالوصول للميكروفون';
}

Swal.fire({
icon: 'error',
title: 'خطأ',
text: errorMessage
});
};
} else {
Swal.fire({
icon: 'warning',
title: 'غير مدعوم',
text: 'المتصفح لا يدعم البحث الصوتي'
});
}
}

// تنفيذ البحث
function performSearch(query) {
const activeFilter = document.querySelector('.chip.active')?.dataset.filter || 'all';
window.location.href = '/search?search=' + encodeURIComponent(query) + '&filter=' + activeFilter;
}

// البحث عند الضغط على Enter
document.getElementById('globalSearch').addEventListener('keypress', function(e) {
if (e.key === 'Enter') {
const query = this.value.trim();
if (query) {
performSearch(query);
}
}
});

// Init theme
const savedTheme = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-theme', savedTheme);
updateIcon(savedTheme);

// إخفاء التنبيه تلقائياً بعد 3 ثواني
setTimeout(() => {
const toast = document.getElementById('dariToast');
if (toast) {
toast.style.animation = 'toastSlideOut 0.4s ease forwards';
setTimeout(() => toast.remove(), 400);
}
}, 3000);

// ========================================
// رسائل التأكيد المخصصة - DARI Confirmations
// ========================================

// تأكيد الحذف
function confirmDelete(formId, itemName) {
itemName = itemName || 'هذا العنصر';
Swal.fire({
title: 'تأكيد الحذف',
html: '<p style="color:#eee;font-size:16px;">هل أنت متأكد من حذف <strong>' + itemName + '</strong>؟</p><p style="color:#ccc;font-size:14px;">لا يمكن التراجع عن هذا الإجراء</p>',
icon: 'warning',
iconColor: '#C4A574',
showCancelButton: true,
confirmButtonText: 'نعم، احذف',
cancelButtonText: 'إلغاء',
background: '#3D4F5F',
color: '#fff',
confirmButtonColor: '#C4A574',
cancelButtonColor: '#6c757d',
reverseButtons: true
}).then((result) => {
if (result.isConfirmed) {
document.getElementById(formId).submit();
}
});
}

// تأكيد تسجيل الخروج
function confirmLogout(formId) {
Swal.fire({
title: 'تسجيل الخروج',
html: '<p style="color:#eee;font-size:16px;">هل أنت متأكد من تسجيل الخروج؟</p>',
icon: 'question',
iconColor: '#C4A574',
showCancelButton: true,
confirmButtonText: 'نعم، خروج',
cancelButtonText: 'إلغاء',
background: '#3D4F5F',
color: '#fff',
confirmButtonColor: '#C4A574',
cancelButtonColor: '#6c757d',
reverseButtons: true
}).then((result) => {
if (result.isConfirmed) {
document.getElementById(formId).submit();
}
});
}

// تأكيد عام (لأي إجراء)
function confirmAction(formId, title, message, confirmText) {
confirmText = confirmText || 'موافق';
Swal.fire({
title: title,
html: '<p style="color:#eee;font-size:16px;">' + message + '</p>',
icon: 'question',
iconColor: '#C4A574',
showCancelButton: true,
confirmButtonText: confirmText,
cancelButtonText: 'إلغاء',
background: '#3D4F5F',
color: '#fff',
confirmButtonColor: '#C4A574',
cancelButtonColor: '#6c757d',
reverseButtons: true
}).then((result) => {
if (result.isConfirmed) {
document.getElementById(formId).submit();
}
});
}

// تأكيد مع رابط (بدون form)
function confirmLink(url, title, message, confirmText) {
confirmText = confirmText || 'موافق';
Swal.fire({
title: title,
html: '<p style="color:#eee;font-size:16px;">' + message + '</p>',
icon: 'question',
iconColor: '#C4A574',
showCancelButton: true,
confirmButtonText: confirmText,
cancelButtonText: 'إلغاء',
background: '#3D4F5F',
color: '#fff',
confirmButtonColor: '#C4A574',
cancelButtonColor: '#6c757d',
reverseButtons: true
}).then((result) => {
if (result.isConfirmed) {
window.location.href = url;
}
});
}

// رسالة نجاح
function showSuccess(message) {
Swal.fire({
title: 'تم بنجاح',
text: message,
icon: 'success',
iconColor: '#C4A574',
confirmButtonText: 'حسناً',
background: '#3D4F5F',
color: '#fff',
confirmButtonColor: '#C4A574'
});
}

// رسالة خطأ
function showError(message) {
Swal.fire({
title: 'خطأ',
text: message,
icon: 'error',
iconColor: '#dc3545',
confirmButtonText: 'حسناً',
background: '#3D4F5F',
color: '#fff',
confirmButtonColor: '#C4A574'
});
}

// ==========================================
// نظام الإشعارات والرسائل التفاعلي
// ==========================================

// إظهار/إخفاء قائمة الإشعارات
function toggleNotifications() {
    const dropdown = document.getElementById('notificationsDropdown');
    const messagesDropdown = document.getElementById('messagesDropdown');
    
    // إخفاء قائمة الرسائل إذا كانت مفتوحة
    if (messagesDropdown) messagesDropdown.classList.remove('show');
    
    // تبديل قائمة الإشعارات
    dropdown.classList.toggle('show');
    
    // تحميل الإشعارات إذا فتحت
    if (dropdown.classList.contains('show')) {
        loadNotifications();
    }
}

// إظهار/إخفاء قائمة الرسائل
function toggleMessages() {
    const dropdown = document.getElementById('messagesDropdown');
    const notifDropdown = document.getElementById('notificationsDropdown');
    
    // إخفاء قائمة الإشعارات إذا كانت مفتوحة
    if (notifDropdown) notifDropdown.classList.remove('show');
    
    // تبديل قائمة الرسائل
    dropdown.classList.toggle('show');
    
    // تحميل الرسائل إذا فتحت
    if (dropdown.classList.contains('show')) {
        loadMessages();
    }
}

// تحميل الإشعارات
function loadNotifications() {
    const container = document.getElementById('notificationsList');
    
    fetch('/notifications/latest', {
        headers: { 
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.notifications && data.notifications.length > 0) {
            container.innerHTML = data.notifications.map(notif => `
                <div class="dropdown-item-custom ${notif.read_at ? '' : 'unread'}" onclick="window.location='${notif.url || '/notifications'}'">
                    <div class="item-icon ${getNotifIconClass(notif.type)}">
                        <i class="bi bi-${getNotifIcon(notif.type)}"></i>
                    </div>
                    <div class="item-content">
                        <div class="item-title">${notif.title || 'إشعار جديد'}</div>
                        <div class="item-text">${notif.message || ''}</div>
                        <div class="item-time"><i class="bi bi-clock"></i> ${notif.time_ago || ''}</div>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = `
                <div class="empty-state">
                    <i class="bi bi-bell-slash d-block"></i>
                    <p>لا توجد إشعارات جديدة</p>
                </div>`;
        }
    })
    .catch(() => {
        container.innerHTML = `
            <div class="empty-state">
                <i class="bi bi-bell-slash d-block"></i>
                <p>لا توجد إشعارات</p>
            </div>`;
    });
}

// تحميل الرسائل
function loadMessages() {
    const container = document.getElementById('messagesList');
    
    fetch('/messages/latest', {
        headers: { 
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.messages && data.messages.length > 0) {
            container.innerHTML = data.messages.map(msg => `
                <div class="dropdown-item-custom ${msg.is_read ? '' : 'unread'}" onclick="window.location='/messages/${msg.id}'">
                    <div class="item-icon msg">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="item-content">
                        <div class="item-title">${msg.sender_name || 'مستخدم'}</div>
                        <div class="item-text">${msg.subject || msg.body || 'رسالة جديدة'}</div>
                        <div class="item-time"><i class="bi bi-clock"></i> ${msg.time_ago || ''}</div>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = `
                <div class="empty-state">
                    <i class="bi bi-envelope-open d-block"></i>
                    <p>لا توجد رسائل جديدة</p>
                </div>`;
        }
    })
    .catch(() => {
        container.innerHTML = `
            <div class="empty-state">
                <i class="bi bi-envelope-open d-block"></i>
                <p>لا توجد رسائل</p>
            </div>`;
    });
}

// الحصول على أيقونة الإشعار حسب النوع
function getNotifIcon(type) {
    const icons = {
        'payment': 'cash-coin',
        'maintenance': 'tools',
        'contract': 'file-earmark-text',
        'message': 'envelope',
        'warning': 'exclamation-triangle',
        'success': 'check-circle',
        'info': 'info-circle',
        'default': 'bell'
    };
    return icons[type] || icons['default'];
}

// الحصول على كلاس الأيقونة حسب النوع
function getNotifIconClass(type) {
    const classes = {
        'payment': 'success',
        'maintenance': 'warning',
        'contract': 'info',
        'message': 'msg',
        'warning': 'warning',
        'success': 'success',
        'info': 'info',
        'default': 'notif'
    };
    return classes[type] || classes['default'];
}

// تحديد كل الإشعارات كمقروءة
function markAllNotificationsRead() {
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(() => {
        // إزالة الشارة
        const badge = document.querySelector('.notification-wrapper .notif-badge-red');
        if (badge) badge.remove();
        
        // إعادة تحميل الإشعارات
        loadNotifications();
        
        // إظهار رسالة نجاح
        Swal.fire({
            icon: 'success',
            title: 'تم',
            text: 'تم تحديد جميع الإشعارات كمقروءة',
            timer: 1500,
            showConfirmButton: false
        });
    })
    .catch(() => {
        // حتى لو فشل، نحاول تحديث الواجهة
        loadNotifications();
    });
}

// تحديد كل الرسائل كمقروءة
function markAllMessagesRead() {
    fetch('/messages/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(() => {
        // إزالة الشارة
        const badge = document.querySelector('.message-wrapper .notif-badge-blue');
        if (badge) badge.remove();
        
        // إعادة تحميل الرسائل
        loadMessages();
        
        // إظهار رسالة نجاح
        Swal.fire({
            icon: 'success',
            title: 'تم',
            text: 'تم تحديد جميع الرسائل كمقروءة',
            timer: 1500,
            showConfirmButton: false
        });
    })
    .catch(() => {
        // حتى لو فشل، نحاول تحديث الواجهة
        loadMessages();
    });
}

// إخفاء القوائم عند الضغط خارجها
document.addEventListener('click', function(e) {
    // إخفاء قائمة الإشعارات
    if (!e.target.closest('.notification-wrapper')) {
        const notifDropdown = document.getElementById('notificationsDropdown');
        if (notifDropdown) notifDropdown.classList.remove('show');
    }
    
    // إخفاء قائمة الرسائل
    if (!e.target.closest('.message-wrapper')) {
        const msgDropdown = document.getElementById('messagesDropdown');
        if (msgDropdown) msgDropdown.classList.remove('show');
    }
});

// تحديث الإشعارات كل 30 ثانية
setInterval(function() {
    // تحديث عدد الإشعارات
    fetch('/notifications/count', {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        const badge = document.querySelector('.notification-wrapper .notif-badge-red');
        if (data.count > 0) {
            if (badge) {
                badge.textContent = data.count > 99 ? '99+' : data.count;
            } else {
                const wrapper = document.querySelector('.notification-wrapper .top-bar-icon');
                if (wrapper) {
                    const newBadge = document.createElement('span');
                    newBadge.className = 'notif-badge notif-badge-red';
                    newBadge.textContent = data.count > 99 ? '99+' : data.count;
                    wrapper.parentElement.appendChild(newBadge);
                }
            }
        } else if (badge) {
            badge.remove();
        }
    })
    .catch(() => {});
    
    // تحديث عدد الرسائل
    fetch('/messages/count', {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        const badge = document.querySelector('.message-wrapper .notif-badge-blue');
        if (data.count > 0) {
            if (badge) {
                badge.textContent = data.count > 99 ? '99+' : data.count;
            } else {
                const wrapper = document.querySelector('.message-wrapper .top-bar-icon');
                if (wrapper) {
                    const newBadge = document.createElement('span');
                    newBadge.className = 'notif-badge notif-badge-blue';
                    newBadge.textContent = data.count > 99 ? '99+' : data.count;
                    wrapper.parentElement.appendChild(newBadge);
                }
            }
        } else if (badge) {
            badge.remove();
        }
    })
    .catch(() => {});
}, 30000);

</script>
<?php echo $__env->yieldPushContent('scripts'); ?>

<!-- Chatbot - للسكان فقط -->
<?php if(auth()->check() && auth()->user()->hasRole('Resident')): ?>
<?php echo $__env->make('components.chatbot', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
</body>
</html>

<?php /**PATH D:\سنة ثالثة ترم ثاني\العملي\لارافل عملي\dari-laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>