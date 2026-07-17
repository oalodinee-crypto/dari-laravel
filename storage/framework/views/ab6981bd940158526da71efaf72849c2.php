<?php $__env->startSection('title', __('messages.payments')); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-4">
    <div class="d-flex justify-content-between mb-3">
        <h5><i class="bi bi-cash-stack me-2"></i> <?php echo e(__('messages.payments')); ?></h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
            <i class="bi bi-plus"></i> <?php echo e(__('messages.add')); ?>

        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo e(__('messages.tenant')); ?></th>
                    <th><?php echo e(__('messages.building')); ?></th>
                    <th><?php echo e(__('messages.type')); ?></th>
                    <th><?php echo e(__('messages.amount')); ?></th>
                    <th><?php echo e(__('messages.date')); ?></th>
                    <th><?php echo e(__('messages.status')); ?></th>
                    <th><?php echo e(__('messages.actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($payment->id); ?></td>
                    <td><?php echo e($payment->tenant->name ?? ($payment->invoice->tenant->name ?? '-')); ?></td>
                    <td><?php echo e($payment->invoice->unit->building->name ?? '-'); ?></td>
                    <td><?php echo e($payment->payment_type ?? __('messages.rent_amount')); ?></td>
                    <td class="text-success fw-bold"><?php echo e(number_format($payment->amount)); ?></td>
                    <td><?php echo e($payment->payment_date ? $payment->payment_date->format('Y-m-d') : $payment->created_at->format('Y-m-d')); ?></td>
                    <td><span class="badge bg-success"><?php echo e(__('messages.paid')); ?></span></td>
                    <td>
                        <a href="<?php echo e(route('payments.show', $payment)); ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                        <a href="<?php echo e(route('payments.edit', $payment)); ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="<?php echo e(route('payments.destroy', $payment)); ?>" method="POST" class="d-inline confirm-delete">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="8" class="text-center py-4 text-muted"><?php echo e(__('messages.no_payments')); ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if(method_exists($payments, 'hasPages') && $payments->hasPages()): ?>
    <div class="mt-3"><?php echo e($payments->links()); ?></div>
    <?php endif; ?>
</div>

<!-- Add Payment Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('messages.add_payment')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('payments.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.invoice')); ?></label>
                        <select name="invoice_id" class="form-select" required>
                            <option value="">-- <?php echo e(__('messages.invoice')); ?> --</option>
                            <?php $__currentLoopData = \App\Models\Invoice::where('status', '!=', 'paid')->with('tenant')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($invoice->id); ?>"><?php echo e($invoice->invoice_number); ?> - <?php echo e($invoice->tenant->name ?? '-'); ?> (<?php echo e(number_format($invoice->total_amount)); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.amount')); ?></label>
                        <input type="number" name="amount" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.payment_method')); ?></label>
                        <select name="method" class="form-select" required>
                            <option value="cash"><?php echo e(__('messages.cash')); ?></option>
                            <option value="bank_transfer"><?php echo e(__('messages.bank_transfer')); ?></option>
                            <option value="check"><?php echo e(__('messages.check')); ?></option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.date')); ?></label>
                        <input type="date" name="payment_date" class="form-control" value="<?php echo e(date('Y-m-d')); ?>" required>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\سنة ثالثة ترم ثاني\العملي\لارافل عملي\dari-laravel\resources\views/payments/index.blade.php ENDPATH**/ ?>