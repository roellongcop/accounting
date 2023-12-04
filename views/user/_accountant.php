<?php

use app\helpers\App;
use app\helpers\Url;
?>
<div class="row">
	<div class="col-md-3">
		<?php $this->beginContent('@app/views/layouts/_card_wrapper.php') ?>
				<div class="text-center mb-8">
					<div class="symbol symbol-60 symbol-circle symbol-xl-90">
						<div class="symbol-label" style="background-image:url(<?= Url::image($model->user->photo) ?>)"></div>
						<i class="symbol-badge symbol-badge-bottom bg-success"></i>
					</div>
					<h4 class="font-weight-bolder my-2">
						<?= $model->fullname ?>
					</h4>
					<div class="text-muted font-weight-bold mb-2">
						<?= $model->job_title ?>
					</div>
					<span class="label label-light-<?= $model->user->isActive ? 'warning': 'danger' ?> label-inline font-weight-bold label-lg">
						<?= $model->user->isActive ? 'Active': 'In-active' ?>
					</span>
				</div>
				<!-- <div class="mb-10 text-center">
					<a href="<?= $model->facebook ?>" class="btn btn-icon btn-circle btn-light-facebook mr-2" target="_blank">
						<i class="socicon-facebook"></i>
					</a>
					<a href="<?= $model->twitter ?>" class="btn btn-icon btn-circle btn-light-twitter mr-2" target="_blank">
						<i class="socicon-twitter"></i>
					</a>
					<a href="<?= $model->instagram ?>" class="btn btn-icon btn-circle btn-light-google" target="_blank">
						<i class="socicon-instagram"></i>
					</a>
				</div> -->

				<a href="<?=  Url::current(['tab' => 'personal']) ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block <?= $tab == 'personal' ? 'active': '' ?>">Personal info</a>

				<a href="<?=  Url::current(['tab' => 'address']) ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block <?= $tab == 'address' ? 'active': '' ?>">Address</a>

				<a href="<?=  Url::current(['tab' => 'professional']) ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block <?= $tab == 'professional' ? 'active': '' ?>">Professional</a>

				<a href="<?=  Url::current(['tab' => 'contact']) ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block <?= $tab == 'contact' ? 'active': '' ?>">Contact Details</a>

				<a href="<?= App::setting('system')->viber_link ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block">Viber Chat</a>
				<!-- <a href="<?=  Url::current(['tab' => 'social']) ?>" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block <?= $tab == 'social' ? 'active': '' ?>">Social Media</a> -->
		<?php $this->endContent(); ?>
	</div>
	<div class="col-md-9">
		<?php $this->beginContent('@app/views/layouts/_card_wrapper.php') ?>
			<?= $this->render("accountant-profile-view/{$tab}", ['model' => $model]) ?>
		<?php $this->endContent(); ?>
	</div>
</div>