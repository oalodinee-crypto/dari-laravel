<?php $__env->startSection('title', __('messages.maintenance_requests')); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><?php echo e(__('messages.maintenance_requests')); ?></h4>
    <a href="<?php echo e(route('maintenance.create')); ?>" class="btn btn-primary">
        <i class="bi bi-plus me-2"></i><?php echo e(__('messages.add_maintenance')); ?>

    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo e(__('messages.name')); ?></th>
                        <th><?php echo e(__('messages.unit')); ?></th>
                        <th><?php echo e(__('messages.user')); ?></th>
                        <th><?php echo e(__('messages.priority')); ?></th>
                        <th><?php echo e(__('messages.status')); ?></th>
                        <th><?php echo e(__('messages.date')); ?></th>
                        <th><?php echo e(__('messages.actions')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $maintenance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($request->id); ?></td>
                        <td>
                            <a href="<?php echo e(route('maintenance.show', $request)); ?>" class="text-decoration-none">
                                <?php echo e(Str::limit($request->title, 30)); ?>

                            </a>
                        </td>
                        <td><?php echo e(Str::limit($request->property->title ?? '-', 20)); ?></td>
                        <td><?php echo e($request->user->name ?? '-'); ?></td>
                        <td>
                            <span class="badge 
                                <?php switch($request->priority):
                                    case ('low'): ?> bg-secondary <?php break; ?>
                                    <?php case ('medium'): ?> bg-info <?php break; ?>
                                    <?php case ('high'): ?> bg-warning <?php break; ?>
                                    <?php case ('urgent'): ?> bg-danger <?php break; ?>
                                <?php endswitch; ?>
                            ">
                                <?php switch($request->priority):
                                    case ('low'): ?> <?php echo e(__('messages.low')); ?> <?php break; ?>
                                    <?php case ('medium'): ?> <?php echo e(__('messages.medium')); ?> <?php break; ?>
                                    <?php case ('high'): ?> <?php echo e(__('messages.high')); ?> <?php break; ?>
                                    <?php case ('urgent'): ?> <?php echo e(__('messages.urgent')); ?> <?php break; ?>
                                <?php endswitch; ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge 
                                <?php switch($request->status):
                                    case ('pending'): ?> bg-warning <?php break; ?>
                                    <?php case ('in_progress'): ?> bg-info <?php break; ?>
                                    <?php case ('completed'): ?> bg-success <?php break; ?>
                                    <?php case ('cancelled'): ?> bg-secondary <?php break; ?>
                                <?php endswitch; ?>
                            ">
                                <?php switch($request->status):
                                    case ('pending'): ?> <?php echo e(__('messages.pending')); ?> <?php break; ?>
                                    <?php case ('in_progress'): ?> <?php echo e(__('messages.in_progress')); ?> <?php break; ?>
                                    <?php case ('completed'): ?> <?php echo e(__('messages.completed')); ?> <?php break; ?>
                                    <?php default: ?> <?php echo e($request->status); ?>

                                <?php endswitch; ?>
                            </span>
                        </td>
                        <td><?php echo e($request->created_at->format('Y/m/d')); ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('maintenance.show', $request)); ?>" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?php echo e(route('maintenance.edit', $request)); ?>" class="btn btn-outline-warning">
                                    <i class="bi bi-edit"></i>
                                </a>
                                <form action="<?php echo e(route('maintenance.destroy', $request)); ?>" method="POST" class="d-inline confirm-delete">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted"><?php echo e(__('messages.no_data')); ?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    <?php echo e($maintenance->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\سنة ثالثة ترم ثاني\العملي\لارافل عملي\dari-laravel\resources\views/maintenance/index.blade.php ENDPATH**/ ?>