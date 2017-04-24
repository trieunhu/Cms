<button type="button" class="btn btn-primary img-upload-my " style="display: none;" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">UP Images</button>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 90%;height: 95%;">
        <div class="modal-content" style="height: 92%;">
            <div class="modal-header no-border" style="padding-bottom: 0px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn-close-upimage">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel">Thư viện ảnh</h4>
            </div>
            <div class="modal-body" style="padding: 7px;">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active"><a data-target="#home" data-toggle="tab">Tải ảnh</a></li>
                    <li><a data-target="#profile" data-toggle="tab">Danh sách ảnh</a></li>
                </ul>

                <div class="tab-content" style="height: 392px;">
                    <div class="tab-pane active select-input" id="home">
                        <div id="dragandrophandler" style="height: 400px;">
                            <form id="uploadForm" action="upload.php" method="post">
                                <input name="userImage" type="file" class="inputFile" style="display: none;" />
                                <button type="button" class="btn btn-default" onclick="$('.inputFile').click(); return;">Chọn ảnh</button>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane" id="profile">
                        <div class="tab-2 row no-margin row">
                            <?= backend\modules\posts\components\images\ListImageWidgets::widget(); ?>

                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <div class="modal-footer" style="border-top-color: #ddd;">
                <button type="button" class="btn btn-primary disabled" style="margin-top: -5px;" id="select-image">Chọn ảnh</button>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
   
</script>
<style>
    .pa-upload-details{padding-left: 10px;margin-right:10px;width: 70%;}
    .div-from-upload{height: 48px;}
    .modal-dialog,
    .modal-content {
        /* 80% of window height */
        height: 92%;
    }
    #home{position: relative;}
    #uploadForm{
        position: absolute;
        top: 180px;
        left: 400px;
    }
    #uploadForm>button{
        width: 200px;
        font-size: 24px;
    }
    #dragandrophandler p{
			font-size: 200%;
			margin-top: 15px;
		}
		#dragandrophandler
		{
			min-height: 100px;
			border:2px dotted #0B85A1;
			width:100%;
			color:#92AAB0;
			text-align:center;vertical-align:middle;
			margin-bottom: 10px;
		}
</style>