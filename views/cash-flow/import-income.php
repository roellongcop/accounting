<?php

use app\helpers\App;
use app\helpers\Url;
use app\widgets\ActiveForm;

$this->title = 'Import';
$this->params['breadcrumbs'][] = ['label' => 'Income', 'url' => Url::to(['cash-flow/income'])];
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['activeMenuLink'] = Url::toRoute(['cash-flow/income']);
?>

<div class="cash-flow-import-page">
<?php $form = ActiveForm::begin(['id' => 'user-form-my-account']); ?>
  <div class="row">
    <div class="col-md-6">
      <?= $form->dropzone($model, 'file', 'Income', [
        'description' => 'Upload XLS or XLSX',
        'maxFiles' => 1,
        'acceptedFiles' => ['.xls', '.xlsx'],
        'success' => <<< JS
          const {token} = s.file;
          KTApp.block('.cash-flow-import-page', {
            overlayColor: '#000000',
            state: 'warning',
            message: 'Validating file...'
          });
          $.ajax({
            url: app.baseUrl + 'cash-flow/import-income?process=validate',
            data: {token: token},
            method: 'post',
            dataType: 'json',
            success: function(s) {
              KTApp.unblock('.cash-flow-import-page');
              if (s.status === "success") {
                Swal.fire({
                  title: s.message,
                  text: "Are you sure to import this file?",
                  icon: "success",
                  showCancelButton: true,
                  confirmButtonText: "Yes, import it!",
                  cancelButtonText: "No, cancel!",
                  reverseButtons: true
                }).then(function(result) {
                  if (result.value) {
                    KTApp.block('.cash-flow-import-page', {
                      overlayColor: '#000000',
                      state: 'warning',
                      message: 'Importing file...'
                    });
                    $.ajax({
                      url: app.baseUrl + 'cash-flow/import-income?process=save',
                      data: {token: token},
                      method: 'post',
                      dataType: 'json',
                      success: function(s) {
                        KTApp.unblock('.cash-flow-import-page');
                        if (s.status === 'success') {
                          Swal.fire('Import Success', s.message, 'success').then(() => {
                            location.reload();
                          });
                        }
                        else {
                          Swal.fire('Import Failed', s.message, 'error');
                        }
                      },
                      error: function(e) {
                        KTApp.unblock('.cash-flow-import-page');
                        alert(e.responseText);
                      }
                    });
                  }
                });
              }
              else {
                Swal.fire('Import Failed', s.message, 'error');
              }
            },
            error: function(e) {
              KTApp.unblock('.cash-flow-import-page');
              alert(e.responseText);
            }
          })
        JS
      ]) ?>
    </div>
    <div class="col-md-6">
      <p class="lead font-weight-bold">Please make sure to upload correct format</p>
      <p>Please download the file for reference by clicking the below button</p>
      <a class="btn btn-outline-secondary font-weight-bold" href="<?= App::baseUrl('default/samples/cashflow-import.xlsx') ?>">
        Download Sample Format
      </a>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div id="import-table-data"></div>
    </div>
  </div>
</div>
<?php ActiveForm::end(); ?>
