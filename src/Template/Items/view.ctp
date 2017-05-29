


 <div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                    <h1 class="page-header"><i class="fa fa-user"></i> User Listing</h1>
                </div>

            </div>
            <button class="btn btn-default" onclick="goBack()">Back</button>
            <div class="row spacing">
                 <div class="col-lg-12">
                        <div class="panel panel-default">
                           

    <div class="panel-body">
        <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
        <tr>
            <th><?= __('Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
         <tr>
            <th><?= __('Role') ?></th>
            <td><?= h($user->role) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($user->id) ?></td>
        </tr>
        <tr>
            <th><?= __('contact_no') ?></th>
            <td><?= $this->Number->format($user->contact_no) ?></td>
        </tr>
        
        <!--tr>
            <th><?= __('Created') ?></th>
            <td><?= h($user->createdAt) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($user->updatedAt) ?></td>
        </tr-->
    </table>

       </div>
            </div>
                    </div>
            </div>
            <!-- /.row -->


        </div>
</div>
    
