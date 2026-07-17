<?php $__env->startSection('title', 'لوحة مالك المبنى'); ?>
<?php $__env->startSection('page-title', 'لوحة التحكم - مالك المبنى'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    
    <div class="row mb-4">
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">المباني</p>
                        <h3 class="mb-0"><?php echo e($stats['total_buildings']); ?></h3>
                    </div>
                    <div class="icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-city"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">الوحدات</p>
                        <h3 class="mb-0"><?php echo e($stats['total_units']); ?></h3>
                    </div>
                    <div class="icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-door-open"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">مؤجرة</p>
                        <h3 class="mb-0"><?php echo e($stats['occupied_units']); ?></h3>
                    </div>
                    <div class="icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-key"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">العقود</p>
                        <h3 class="mb-0"><?php echo e($stats['active_contracts']); ?></h3>
                    </div>
                    <div class="icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-file-contract"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">صيانة معلقة</p>
                        <h3 class="mb-0 text-danger"><?php echo e($stats['pending_maintenance']); ?></h3>
                    </div>
                    <div class="icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-tools"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">فواتير معلقة</p>
                        <h3 class="mb-0 text-warning"><?php echo e($stats['pending_invoices']); ?></h3>
                    </div>
                    <div class="icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-file-invoice"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <a href="<?php echo e(route('contracts.create')); ?>" class="btn btn-primary w-100">
                <i class="bi bi-plus me-2"></i>عقد جديد
            </a>
        </div>
        <div class="col-md-3 mb-2">
            <a href="<?php echo e(route('invoices.create')); ?>" class="btn btn-success w-100">
                <i class="bi bi-file-invoice me-2"></i>فاتورة جديدة
            </a>
        </div>
        <div class="col-md-3 mb-2">
            <a href="<?php echo e(route('maintenance.index')); ?>" class="btn btn-warning w-100">
                <i class="bi bi-tools me-2"></i>طلبات الصيانة
            </a>
        </div>
        <div class="col-md-3 mb-2">
            <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-info w-100">
                <i class="bi bi-chart-bar me-2"></i>التقارير
            </a>
        </div>
    </div>

    <div class="row">
        
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-file-contract me-2"></i>آخر العقود</h5>
                    <a href="<?php echo e(route('contracts.index')); ?>" class="btn btn-sm btn-light">عرض الكل</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr><th>العقد</th><th>المستأجر</th><th>الوحدة</th><th>الحالة</th></tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $recentContracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($contract->contract_number); ?></td>
                                    <td><?php echo e($contract->tenant->name ?? '-'); ?></td>
                                    <td><?php echo e($contract->unit->unit_number ?? '-'); ?></td>
                                    <td>
                                        <?php if($contract->status == 'active'): ?>
                                            <span class="badge bg-success">نشط</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary"><?php echo e($contract->status); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr><td colspan="4" class="text-center py-3">لا توجد عقود</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-tools me-2"></i>طلبات صيانة معلقة</h5>
                    <a href="<?php echo e(route('maintenance.index')); ?>" class="btn btn-sm btn-light">عرض الكل</a>
                </div>
                <div class="card-body">
                    <?php $__empty_1 = true; $__currentLoopData = $pendingMaintenance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <strong><?php echo e($request->title); ?></strong>
                                <br>
                                <small class="text-muted"><?php echo e($request->user->name ?? ''); ?> - <?php echo e($request->created_at->diffForHumans()); ?></small>
                            </div>
                            <a href="<?php echo e(route('maintenance.show', $request)); ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-center text-muted py-3">لا توجد طلبات معلقة</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <?php if($announcements->count() > 0): ?>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-bullhorn me-2"></i>الإعلانات</h5>
        </div>
        <div class="card-body">
            <?php $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="alert alert-info mb-2">
                    <strong><?php echo e($announcement->title); ?></strong>
                    <p class="mb-0 small"><?php echo e(Str::limit($announcement->content, 100)); ?></p>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\سنة ثالثة ترم ثاني\العملي\لارافل عملي\dari-laravel\resources\views/dashboard/manager.blade.php ENDPATH**/ ?>