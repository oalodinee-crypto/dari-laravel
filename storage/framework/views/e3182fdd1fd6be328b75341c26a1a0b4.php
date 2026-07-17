<?php $__env->startSection('title', __('messages.contracts')); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-4">
    <div class="d-flex justify-content-between mb-3">
        <h5><i class="bi bi-file-earmark-text me-2"></i> <?php echo e(__('messages.contracts')); ?></h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addContractModal">
            <i class="bi bi-plus"></i> <?php echo e(__('messages.add')); ?>

        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><?php echo e(__('messages.contract_number')); ?></th>
                    <th><?php echo e(__('messages.tenant')); ?></th>
                    <th><?php echo e(__('messages.unit')); ?></th>
                    <th><?php echo e(__('messages.building')); ?></th>
                    <th><?php echo e(__('messages.start_date')); ?></th>
                    <th><?php echo e(__('messages.end_date')); ?></th>
                    <th><?php echo e(__('messages.status')); ?></th>
                    <th><?php echo e(__('messages.actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $contracts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contract): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($contract->contract_number); ?></td>
                    <td><?php echo e($contract->tenant->name ?? __('messages.not_specified')); ?></td>
                    <td><?php echo e($contract->unit->unit_number ?? '-'); ?></td>
                    <td><?php echo e($contract->unit->building->name ?? '-'); ?></td>
                    <td><?php echo e($contract->start_date ? $contract->start_date->format('Y-m-d') : '-'); ?></td>
                    <td><?php echo e($contract->end_date ? $contract->end_date->format('Y-m-d') : '-'); ?></td>
                    <td>
                        <?php if($contract->status == 'active'): ?>
                            <span class="badge bg-success"><?php echo e(__('messages.active')); ?></span>
                        <?php elseif($contract->status == 'expired'): ?>
                            <span class="badge bg-danger"><?php echo e(__('messages.expired')); ?></span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark"><?php echo e(__('messages.pending')); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="table-actions">
                        <a href="<?php echo e(route('contracts.edit', $contract)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('contracts.destroy', $contract)); ?>" method="POST" class="d-inline confirm-delete">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center py-4 text-muted"><?php echo e(__('messages.no_contracts')); ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if(method_exists($contracts, 'hasPages') && $contracts->hasPages()): ?>
    <div class="mt-3"><?php echo e($contracts->links()); ?></div>
    <?php endif; ?>
</div>

<!-- Add Contract Modal -->
<div class="modal fade" id="addContractModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('messages.add_contract')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('contracts.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.tenant')); ?></label>
                        <select name="tenant_id" class="form-select" required>
                            <option value=""><?php echo e(__('messages.select_tenant')); ?></option>
                            <?php $__currentLoopData = \App\Models\User::whereHas('roles', function($q) { $q->where('name', 'Resident'); })->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tenant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tenant->id); ?>"><?php echo e($tenant->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.unit')); ?></label>
                        <select name="unit_id" class="form-select" required>
                            <option value=""><?php echo e(__('messages.select_unit')); ?></option>
                            <?php $__currentLoopData = \App\Models\Unit::where('status', 'available')->with('building')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($unit->id); ?>"><?php echo e($unit->building->name ?? ''); ?> - <?php echo e($unit->unit_number); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('messages.type')); ?></label>
                            <select name="type" class="form-select" required>
                                <option value="rent">إيجار</option>
                                <option value="lease">تأجير</option>
                                <option value="sale">بيع</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('messages.payment_frequency')); ?></label>
                            <select name="payment_frequency" class="form-select" required>
                                <option value="monthly">شهري</option>
                                <option value="quarterly">ربع سنوي</option>
                                <option value="semi_annual">نصف سنوي</option>
                                <option value="annual">سنوي</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('messages.start_date')); ?></label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><?php echo e(__('messages.end_date')); ?></label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.monthly_rent')); ?></label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <input type="hidden" name="status" value="active">
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\سنة ثالثة ترم ثاني\العملي\لارافل عملي\dari-laravel\resources\views/contracts/index.blade.php ENDPATH**/ ?>