<?php $__env->startSection('title', __('messages.units')); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-4">
    <div class="d-flex justify-content-between mb-3">
        <h5><i class="bi bi-door-open me-2"></i> <?php echo e(__('messages.units')); ?></h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUnitModal">
            <i class="bi bi-plus"></i> <?php echo e(__('messages.add')); ?>

        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><?php echo e(__('messages.unit_number')); ?></th>
                    <th><?php echo e(__('messages.building')); ?></th>
                    <th><?php echo e(__('messages.type')); ?></th>
                    <th><?php echo e(__('messages.status')); ?></th>
                    <th><?php echo e(__('messages.rent_amount')); ?></th>
                    <th><?php echo e(__('messages.tenant')); ?></th>
                    <th><?php echo e(__('messages.actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($unit->unit_number); ?></td>
                    <td><?php echo e($unit->building->name ?? '-'); ?></td>
                    <td>
                        <?php switch($unit->type):
                            case ('apartment'): ?> <?php echo e(__('messages.apartment')); ?> <?php break; ?>
                            <?php case ('studio'): ?> <?php echo e(__('messages.studio')); ?> <?php break; ?>
                            <?php case ('office'): ?> <?php echo e(__('messages.office')); ?> <?php break; ?>
                            <?php case ('shop'): ?> <?php echo e(__('messages.shop')); ?> <?php break; ?>
                            <?php case ('storage'): ?> <?php echo e(__('messages.storage')); ?> <?php break; ?>
                            <?php default: ?> <?php echo e($unit->type); ?>

                        <?php endswitch; ?>
                    </td>
                    <td>
                        <span class="badge bg-<?php echo e($unit->status == 'occupied' ? 'success' : ($unit->status == 'available' ? 'warning' : 'secondary')); ?>">
                            <?php echo e($unit->status == 'occupied' ? __('messages.occupied') : ($unit->status == 'available' ? __('messages.vacant') : __('messages.maintenance'))); ?>

                        </span>
                    </td>
                    <td><?php echo e(number_format($unit->amount ?? $unit->rent_amount ?? 0)); ?></td>
                    <td><?php echo e($unit->tenant->name ?? '-'); ?></td>
                    <td class="table-actions">
                        <a href="<?php echo e(route('units.edit', $unit)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('units.destroy', $unit)); ?>" method="POST" class="d-inline confirm-delete">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="7" class="text-center py-4 text-muted"><?php echo e(__('messages.no_units')); ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($units->hasPages()): ?>
    <div class="mt-3"><?php echo e($units->links()); ?></div>
    <?php endif; ?>
</div>

<!-- Add Unit Modal -->
<div class="modal fade" id="addUnitModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('messages.add_unit')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('units.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.unit_number')); ?></label>
                        <input type="text" name="unit_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.building')); ?></label>
                        <select name="building_id" class="form-select" required>
                            <?php $__currentLoopData = \App\Models\Building::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $building): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($building->id); ?>"><?php echo e($building->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('messages.floor_number')); ?></label>
                            <input type="number" name="floor_number" class="form-control" value="1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('messages.type')); ?></label>
                            <select name="type" class="form-select" required>
                                <option value="apartment"><?php echo e(__('messages.apartment')); ?></option>
                                <option value="studio"><?php echo e(__('messages.studio')); ?></option>
                                <option value="office"><?php echo e(__('messages.office')); ?></option>
                                <option value="shop"><?php echo e(__('messages.shop')); ?></option>
                                <option value="storage"><?php echo e(__('messages.storage')); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.monthly_rent')); ?></label>
                        <input type="number" name="rent_amount" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.status')); ?></label>
                        <select name="status" class="form-select" required>
                            <option value="available"><?php echo e(__('messages.vacant')); ?></option>
                            <option value="occupied"><?php echo e(__('messages.occupied')); ?></option>
                            <option value="maintenance"><?php echo e(__('messages.maintenance')); ?></option>
                            <option value="reserved"><?php echo e(__('messages.reserved')); ?></option>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\سنة ثالثة ترم ثاني\العملي\لارافل عملي\dari-laravel\resources\views/units/index.blade.php ENDPATH**/ ?>