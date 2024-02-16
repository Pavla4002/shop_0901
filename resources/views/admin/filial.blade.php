@extends('layout.app')
@section('title')
    Админ.Филиалы
@endsection
@section('main')
    <div class="container-fluid w-75" id="filials">
    <div class="w-100 d-flex justify-content-sm-between align-items-center">
        <h1>Филиалы</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="height: 40px">
            Создать
        </button>
    </div>
{{--        Модальное окно--}}
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Создание филиала</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="CreateFilial()" id="create_filial">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Название филиала</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Адрес филиала</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="address">
                            </div>
                            <button type="submit" class="btn btn-primary">Создать</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<!-- {{--        /Модальное окно--}} -->
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Название</th>
                    <th scope="col">Адрес</th>
                    <th scope="col">Что-то</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="filial in data">
                    <th scope="row">@{{filial.id}}</th>
                    <td>@{{filial.title}}</td>
                    <td>@{{filial.address}}</td>
                    <td>
                        <a class="btn btn-danger" :href="`{{route('delete_filial')}}/${filial.id}`">Удалить</a>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal_1" @click="filial_info=filial">
                            Изменить
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
<!-- {{--           Модальное окно изменения филиалов --}} -->
            <div class="modal fade" id="exampleModal_1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Изменение филиалов</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="EditFilial(filial_info.id)" id="edit_filial_form">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Название филиала</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title" :value="filial_info.title">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Адрес филиала</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="address" :value="filial_info.address">
                                </div>
                                <button type="submit" class="btn btn-primary">Изменить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
<!-- {{--           /Модальное окно изменения филиалов --}} -->
        </div>
    </div>

    <script>
        const app={
            data(){
                return{
                    data:[],
                    filial_info:'',
                    // filial_name:'',
                    // filial_address:'',
                }
            },
            methods:{
                async CreateFilial(){
                    let form = document.getElementById('create_filial');
                    let form_data = new FormData(form);
                    let response = await fetch('{{route('save_filial')}}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        },
                        body: form_data
                    })
                    this.data = await response.json();
                },
                async GetData(){
                    let response = await fetch('{{route('get_filial')}}');
                    this.data = await response.json();
                },
                async EditFilial(id_filial){
                    let form = document.getElementById('edit_filial_form');
                    let form_data= new FormData(form);
                    form_data.append('id',id_filial);
                    let response = await fetch('{{route('edit_filial')}}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        },
                        body:form_data
                    })
                    this.data = await response.json();
                }
            },
           mounted(){
                this.GetData()
            }
        }
        Vue.createApp(app).mount('#filials')
    </script>
@endsection
