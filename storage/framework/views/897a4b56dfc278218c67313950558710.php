<?php $__env->startSection('title', __('messages.users')); ?>

<?php $__env->startSection('content'); ?>
<div class="card p-4">
    <div class="d-flex justify-content-between mb-3">
        <h5><i class="bi bi-people me-2"></i> <?php echo e(__('messages.users')); ?></h5>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-plus"></i> <?php echo e(__('messages.add')); ?>

        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><?php echo e(__('messages.name')); ?></th>
                    <th><?php echo e(__('messages.email')); ?></th>
                    <th><?php echo e(__('messages.phone')); ?></th>
                    <th><?php echo e(__('messages.role')); ?></th>
                    <th><?php echo e(__('messages.actions')); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td><?php echo e($user->phone ?? '-'); ?></td>
                    <td>
                        <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-<?php echo e($role->name == 'Admin' ? 'danger' : ($role->name == 'Manager' ? 'success' : 'info')); ?>">
                                <?php echo e($role->name); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td class="table-actions">
                        <a href="<?php echo e(route('users.edit', $user)); ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                        <?php if($user->id !== auth()->id()): ?>
                        <form action="<?php echo e(route('users.destroy', $user)); ?>" method="POST" class="d-inline confirm-delete">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr><td colspan="5" class="text-center py-4 text-muted"><?php echo e(__('messages.no_data')); ?></td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if($users->hasPages()): ?>
    <div class="mt-3"><?php echo e($users->links()); ?></div>
    <?php endif; ?>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__('messages.add_user')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('users.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.name')); ?></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.email')); ?></label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.phone')); ?></label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.password')); ?></label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.confirm_password')); ?></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo e(__('messages.role')); ?></label>
                        <select name="role" class="form-select" required>
                            <option value="Manager"><?php echo e(__('messages.managers')); ?></option>
                            <option value="Resident"><?php echo e(__('messages.residents')); ?></option>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\سنة ثالثة ترم ثاني\العملي\لارافل عملي\dari-laravel\resources\views/users/index.blade.php ENDPATH**/ ?>