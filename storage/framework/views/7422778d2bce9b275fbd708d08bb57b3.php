<?php $__env->startSection('title', __('messages.buildings')); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-4">
    <div class="d-flex justify-content-between mb-3">
        <h5><i class="bi bi-building me-2"></i> <?php echo e(__('messages.buildings')); ?></h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBuildingModal">
            <i class="bi bi-plus"></i> <?php echo e(__('messages.add_building')); ?>

        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover" id="buildingsTable">
            <thead>
                <tr>
                    <th><?php echo e(__('messages.building_name')); ?></th>
                    <th><?php echo e(__('messages.building_address')); ?></th>
                    <th><?php echo e(__('messages.units_count')); ?></th>
                    <th><?php echo e(__('messages.manager')); ?></th>
                    <th><?php echo e(__('messages.rent_arrears')); ?></th>
                    <th><?php echo e(__('messages.pending_bills')); ?></th>
                    <th><?php echo e(__('messages.actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $buildings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $building): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($building->name); ?></td>
                    <td><?php echo e($building->city); ?> - <?php echo e($building->district ?? $building->address); ?></td>
                    <td><?php echo e($building->units_count ?? $building->units->count()); ?></td>
                    <td><?php echo e($building->manager->name ?? '-'); ?></td>
                    <td>
                        <?php
                            $rentArrears = $building->units->sum(function($unit) {
                                return $unit->contracts->where('status', 'active')->sum('arrears') ?? 0;
                            });
                        ?>
                        <?php if($rentArrears > 0): ?>
                            <span class="badge bg-danger"><?php echo e(number_format($rentArrears)); ?></span>
                        <?php else: ?>
                            <span class="badge bg-success"><?php echo e(__('messages.no_arrears')); ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php
                            $pendingBills = $building->units->sum(function($unit) {
                                return $unit->invoices->where('status', 'pending')->sum('total_amount') ?? 0;
                            });
                        ?>
                        <?php if($pendingBills > 0): ?>
                            <span class="badge bg-warning text-dark"><?php echo e(number_format($pendingBills)); ?></span>
                        <?php else: ?>
                            <span class="badge bg-success"><?php echo e(__('messages.all_paid')); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="table-actions">
                        <a href="<?php echo e(route('buildings.show', $building)); ?>" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="<?php echo e(route('buildings.edit', $building)); ?>" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="<?php echo e(route('buildings.destroy', $building)); ?>" method="POST" class="d-inline confirm-delete">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center py-4">
                        <i class="bi bi-building fs-1 text-muted"></i>
                        <p class="text-muted mt-2"><?php echo e(__('messages.no_buildings')); ?></p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($buildings->hasPages()): ?>
    <div class="mt-3">
        <?php echo e($buildings->links()); ?>

    </div>
    <?php endif; ?>
</div>

<!-- Add Building Modal -->
<div class="modal fade" id="addBuildingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('messages.add_new_building')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('buildings.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.building_name')); ?></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.code')); ?></label>
                        <input type="text" name="code" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('messages.city')); ?></label>
                            <input type="text" name="city" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('messages.area')); ?></label>
                            <input type="text" name="district" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.building_address')); ?></label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('messages.floors_count')); ?></label>
                            <input type="number" name="floors_count" class="form-control" min="1" value="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('messages.year_built')); ?></label>
                            <input type="number" name="year_built" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.manager')); ?></label>
                        <select name="manager_id" class="form-select">
                            <option value=""><?php echo e(__('messages.select_manager')); ?></option>
                            <?php $__currentLoopData = \App\Models\User::whereHas('roles', function($q) { $q->whereIn('name', ['Admin', 'Manager']); })->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($manager->id); ?>"><?php echo e($manager->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.status')); ?></label>
                        <select name="status" class="form-select" required>
                            <option value="active"><?php echo e(__('messages.active')); ?></option>
                            <option value="maintenance"><?php echo e(__('messages.maintenance')); ?></option>
                            <option value="inactive"><?php echo e(__('messages.inactive')); ?></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('messages.cancel')); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('messages.save')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\سنة ثالثة ترم ثاني\العملي\لارافل عملي\dari-laravel\resources\views/buildings/index.blade.php ENDPATH**/ ?>