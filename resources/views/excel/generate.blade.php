<div class="modal fade" id="GenerateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Создать excel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{route('file_generate')}}" enctype="multipart/form-data">
                    @csrf
                    <h5>Тип файла</h5>
                    <v-divider></v-divider>
                    <div class="row">
                        <div class="col">
                            <select class="form-control" name="doc_type" id="doc_type" onchange="checkIfRadio()" required>
                                <option></option>
                                @can('readWaybills')<option value="income">Накладная</option>@endcan
                                @can('readDetailCard')<option value="detail">Учётная карточка</option>@endcan
                            </select>
                        </div>
                    </div>
                    <v-divider></v-divider>
                    <div class="row">
                        <div class="col" id="income_div">
                            <h5>Название документа</h5>
                            <v-divider></v-divider>
                            <select class="form-control" name="doc_name_contract">
                                <option></option>
                                @foreach($contracts as $contract)
                                    <option value="{{$contract->waybillTitle}}">{{$contract->waybillTitle}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col" id="detail_div">
                            <h5>Название транспорта</h5>
                            <v-divider></v-divider>
                            <div class="m-1">
                                <select class="form-control" name="doc_name_transport">
                                    <option></option>
                                    @foreach($transports as $transport)
                                        <option value="{{$transport->title}}">{{$transport->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <input placeholder="Период с" onfocus="(this.type='date')" onblur="(this.type='text')" id="date" type="date" class="form-control m-1" name="doc_name_start_date">
                                </div>
                                <div class="col">
                                    <input placeholder="Период по" onfocus="(this.type='date')" onblur="(this.type='text')" id="date" type="date" class="form-control m-1" name="doc_name_end_date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Скачать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('income_div').style.display='none';
        document.getElementById('detail_div').style.display='none';
        function checkIfRadio(){
            if(document.getElementById('doc_type').value=="income") {
                document.getElementById('income_div').style.display='block';
                document.getElementById('detail_div').style.display='none';
            } else{
                document.getElementById('income_div').style.display='none';
                document.getElementById('detail_div').style.display='block';
            }
        }
    </script>
</div>
