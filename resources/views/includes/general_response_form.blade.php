

<!-- RESPONSE MODAL -->
    <div class="modal fade" id="generalResponseModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defaultModalLabel">Response</h4>
                </div>
                <div class="modal-body" id="" >
                    <form name="import_excel" id="responseMainForm" onsubmit="false;" class="form form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="body">
                            <div class="row clearfix">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea type="text" class="form-control" name="response_message" placeholder="Respond or Reply"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="submitDefaultWithItems('generalResponseModal','responseMainForm','<?php echo url($submitUrl); ?>','reload_data',
                            '<?php echo url($reloadUrl); ?>','<?php echo csrf_token(); ?>','<?php echo $itemClass; ?>')" class="btn btn-info">
                        <i class="fa fa-check-square-o"></i>Respond
                    </button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>
    </div>