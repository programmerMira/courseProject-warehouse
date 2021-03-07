<div class="modal fade" id="UploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Загрузить excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('file_upload')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control mb-4" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                    <div class="row ml-1">
                        @can('readWaybills')
                            <div class="col radio">
                                <label><input type="radio" class="mr-1" name="doc_type" id="income" value="Накладная" required>Накладная</label>
                            </div>
                        @endcan
                        <!--
                        @can('readDetailCard')
                            <div class="col radio">
                                <label><input type="radio" class="mr-1" name="doc_type" id="cards" value="Карточка детали" required>Учётная карточка</label>
                            </div>
                        @endcan
                        -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary" id="download">Загрузить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
