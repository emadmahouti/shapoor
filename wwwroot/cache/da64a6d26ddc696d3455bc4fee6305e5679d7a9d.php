<?php $__env->startSection('content'); ?>
	<p id="status"></p>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<script>
	if("<?php echo e($status); ?>" === 'ok')
		window.location.replace("<?php echo e($data); ?>");
	else
		document.getElementById('status').innerText = "<?php echo e($status); ?>";
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/cp36027/cafeoperations.ir/app/Views/guideline/index.blade.php ENDPATH**/ ?>