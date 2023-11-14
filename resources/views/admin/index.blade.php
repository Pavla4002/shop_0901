@extends('layout.app')
@section('title')
    Админ
@endsection
@section('main')
    <div class="container-fluid w-75" id="categories">
        <div class="w-100 d-flex justify-content-sm-between align-items-center">
            <h1>
                Характеристики
            </h1>
            <div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal_characters">
                    Создать
                </button>
            </div>
            <div class="modal fade" id="exampleModal_characters" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Создание характеристики</h1>
                        </div>
                        <div class="modal-body">
                            <h4>Основные данные *</h4>
                            <form id="form" @submit.prevent="save" method="post">
                                <div :class="message ? 'alert alert-success': ''">
                                        @{{message}}
                                </div>
                                <span>Выберете вид характеристики</span>
                                <select name="select" id="select" class="form-select" v-model="select_character" :change="check_character_select">
                                    <option value="0">Тип</option>
                                    <option value="1">Материал</option>
                                    <option value="2">Вставка</option>
                                    <option value="3">Кому</option>
                                    <option value="4">Проба</option>
                                    <option value="5">Огранка</option>
                                </select>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Введите название характеристики</label>
                                    <input type="text" class="form-control" id="title" name="title" :class="errors.title ? 'is-invalid': ''">
                                    <div class="invalid-feedback" v-for="error in errors.title">
                                        @{{ errors }}
                                    </div>
                                </div>
                                <h4>Связанные характеристики (если есть)</h4>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="status" v-model="yes_subtypes" :change="add_subtype">
                                            <label class="form-check-label" for="status">Есть подтип?</label>
                                        </div>
                                        <div class="d-none" id="box_input_subtypes">
                                            <button class="btn btn-info" @click="add_subtype_input" type="button"> + Добавить подтип</button>
                                            <div class="mb-3">
                                                <label for="enter_character" class="form-label">Введите подкатегорию</label>
                                                <input type="text" class="form-control" id="enter_character" v-for="subtype in subtypes_new" name="subtypes[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="size" v-model="yes_sizes" :change="add_size">
                                            <label class="form-check-label" for="size">Есть размерный ряд?</label>
                                        </div>
                                        <div class="d-none" id="box_input_sizes">
                                            <button class="btn btn-info" @click="add_size_input" type="button"> + Добавить рфзмер</button>
                                            <div class="mb-3">
                                                <label for="enter_size" class="form-label">Введите размер(ы)</label>
                                                <input type="text" class="form-control" id="enter_size" v-for="size in sizes_new" name="sizes[]">
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div>
            <div class="d-flex justify-content-sm-between w-100 mb-5">
                <button class="btn btn-info" style="width: 150px; height: 40px" @click="data=types" >Тип</button>
                <button class="btn btn-info" style="width: 150px; height: 40px" @click="data=stones" >Вставки</button>
                <button class="btn btn-info" style="width: 150px; height: 40px" @click="data=cuttings" >Огранка</button>
                <button class="btn btn-info" style="width: 150px; height: 40px" @click="data=samples" >Проба</button>
                <button class="btn btn-info" style="width: 150px; height: 40px" @click="data=whomes" >Кому</button>
                <button class="btn btn-info" style="width: 150px; height: 40px" @click="data=materials" >Материал</button>
            </div>

            <div class="w-100 d-flex justify-content-sm-between">
                <div class="w-50">
                    <table class="table w-100">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Название</th>
                            <th scope="col">Связанные</th>
                            <th scope="col">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="char in data">
                            <th scope="row">@{{char.id}}</th>
                            <td>@{{char.title}}</td>
                            <td v-if="char.sizes || char.subtypes">
                                <button v-if="char.subtypes.length != 0" class="btn btn-primary" @click="info_subtype=char.subtypes; info_size=[]">Подтип</button>
                                <br>
                                <button v-if="char.sizes.length != 0" class="btn btn-primary" @click="info_size=char.sizes;info_subtype=[]">Размер</button>
                            </td>
                            <td v-else>Нет</td>
                            <td>
                                <button type="submit" class="btn btn-info" style="width: 100px; height: 40px; margin-right: 5px">Изменить</button>
                                <a type="submit" class="btn btn-danger" style="width: 100px; height: 40px">Удалить</a>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
{{--                Обще окно подтипов и размеров--}}
         <div>
{{--             Окно подтипов--}}
             <div v-if="info_subtype.length!=0" class="border border-primary p-2 d-flex flex-md-column justify-content-sm-between" style="min-height: 300px">
                 <div>
                     <div class="w-100 d-flex justify-content-end mb-2">
                         <button class="btn btn-danger" @click="info_subtype=[], show_add_sub_window=false">X</button>
                     </div>
                     <div class="d-flex justify-content-between" v-for="inf in info_subtype" >
                         <form class="w-100 d-flex justify-content-sm-between" :id="'form_subtype_edit_' + inf.id" @submit.prevent="EditSubtype(inf.id, inf.type_id)">
                             <div class="mb-3" style="width:200px">
                                 <input type="text" class="form-control border-0" id="exampleInputEmail1" aria-describedby="emailHelp" :value="inf.title" name="title">
                             </div>
                             <button type="submit" class="btn btn-primary" style="width: 100px; height: 40px; margin-right: 5px">Изменить</button>
                         </form>
                         <button class="btn btn-danger" style="width: 100px; height: 40px" @click="DeleteSub(inf.id, inf.type_id, 'subtypes')">Удалить</button>
                     </div>
                 </div>
                 <div class="d-flex justify-content-end align-items-end">
                     <button class="btn btn-primary" @click="show_add_sub()">Создать</button>
                 </div>
             </div>
{{--             Окно размеров--}}
             <div v-if="info_size.length!=0" class="border border-primary p-2" style="height: 300px">
                 <div class="">
                     <div class="w-100 d-flex justify-content-end mb-2">
                         <button class="btn btn-danger" @click="info_size=[],show_add_sub_window=false">X</button>
                     </div>
                     <div class="d-flex justify-content-between" v-for="info in info_size">
                         <form class="w-100 d-flex justify-content-sm-between" :id="'form_sizes_edit_' + info.id" @submit.prevent="EditSizes(info.id, info.type_id)">
                             <div class="mb-3" style="width:200px">
                                 <input type="text" class="form-control border-0" id="number" :value="info.number" name="number">
                             </div>
                             <button type="submit" class="btn btn-primary" style="width: 100px; height: 40px; margin-right: 5px">Изменить</button>
                         </form>
                         <button class="btn btn-danger" style="width: 100px; height: 40px" @click="DeleteSub(info.id, info.type_id, 'sizes')">Удалить</button>
                     </div>
                 </div>
                 <div>
                     <button class="btn btn-primary" @click="show_add_sub()">
                         Создать
                     </button>
                 </div>
             </div>
{{--             Окно закончилось--}}
{{--             Окно добавление новых сабов--}}
             <div class="" v-show="show_add_sub_window">
                 <div>
                     <h5>Создание новой подхарактеристики</h5>
                 </div>
                 <select name="" id="select_new_sub" class="w-100 mb-3">
                     <option value="0" disabled selected>Выбери</option>
                     <option value="subtype">Подтип</option>
                     <option value="size">Размерчик</option>
                 </select>
                 <div class="w-100 mb-3">
                     <input type="text" class="w-100">
                 </div>
                 <div class="w-100 d-flex justify-content-end">
                     <button class="btn btn-primary">Добавить</button>
                 </div>
             </div>
             {{--             /Окно добавление новых сабов--}}
         </div>
                {{--                /Обще окно подтипов и размеров--}}
            </div>
        </div>
    </div>
    <script>
        const app={
            data(){
                return{
                    types:[],
                    stones:[],
                    cuttings:[],
                    whomes:[],
                    materials:[],
                    samples:[],

                    data:[],
                    info_subtype:[],
                    info_size:[],

                    select_character:0,

                    yes_subtypes:0,
                    yes_sizes:0,

                    subtypes_new:[],
                    sizes_new:[],

                    errors:[],
                    message:'',

                    subtype_error:[],
                    message_subtype:'',

                //    Окно сабов
                    show_add_sub_window: false
                }
            },
            methods:{
                async getCategories(){
                   let response_type = await fetch('{{route('get_type')}}');
                   let response_stones = await fetch('{{route('get_stone')}}');
                   let response_cuttings = await fetch('{{route('get_cutting')}}');
                   let response_whomes = await fetch('{{route('get_whom')}}');
                   let response_materials = await fetch('{{route('get_material')}}');
                   let response_samples = await fetch('{{route('get_sample')}}');

                   this.types = await response_type.json();
                   this.stones = await response_stones.json();
                   this.cuttings = await response_cuttings.json();
                   this.whomes = await response_whomes.json();
                   this.materials = await response_materials.json();
                   this.samples = await response_samples.json();
                   this.data = this.types;
                },
                // Изменение подтипов
                async EditSubtype(id, typeId){
                    let form = document.getElementById('form_subtype_edit_'+ id);
                    let data = new FormData(form);
                    data.append('id',id)
                    data.append('type_id',typeId)

                    const response = await fetch('{{route('edit_subtype')}}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        },
                        body:data,
                    });
                    this.info_subtype = await response.json()
                    let response_type = await fetch('{{route('get_type')}}');
                    this.types = await response_type.json();
                    this.data = this.types;
                },
                async EditSizes(id, typeId){
                    let form = document.getElementById('form_sizes_edit_'+ id);
                    let data = new FormData(form)
                    data.append('id',id)
                    data.append('type_id',typeId)

                    const response = await fetch('{{route('edit_sizes')}}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        },
                        body:data,
                    });
                    this.info_size = await response.json();
                    let response_type = await fetch('{{route('get_type')}}');
                    this.types = await response_type.json();
                    this.data = this.types;
                },
                async DeleteSub(id,type,sub){
                    $route='';
                    $nado =0;
                    if(sub==='subtypes'){
                        $route = '{{route('destroy_subtypes')}}';
                        $nado=1;
                    }
                    if(sub==='sizes'){
                        $route = '{{route('destroy_sizes')}}';
                        $nado=2;
                    }
                    const response = await fetch($route,{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}',
                            'Content-Type':'application/json'
                        },
                        body:JSON.stringify({
                            id:id,
                            type:type
                        }),
                    });
                    this.getCategories()
                    if($nado===1){
                        this.info_subtype = await response.json();
                        console.log(this.info_subtype);
                    }
                    if($nado===2){
                        this.info_size = await response.json();
                        console.log(this.info_size);
                    }
                    let response_type = await fetch('{{route('get_type')}}');
                    this.types = await response_type.json();
                },
                show_add_sub(){
                    this.show_add_sub_window = true;
                },
                add_subtype_input(){
                    this.subtypes_new.push('');
                },
                add_size_input(){
                  this.sizes_new.push('');
                },
                async save(){
                    let form = document.getElementById('form');
                    let data = new FormData(form);
                    const response = await fetch(this.check_character_select,{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        },
                        body:data,
                    });
                    if(response.status===400){
                        this.errors = await response.json();
                    }
                    if(response.status===200){
                        this.message = await response.json();
                        form.reset();
                        this.subtypes_new=[];
                        this.sizes_new=[];
                    }
                },
            },
            computed: {
                check_character_select(){
                    switch(parseInt(this.select_character)){
                        case 0:
                          return '{{route('type_save')}}';
                        case 1:
                              return '{{route('material_save')}}';
                        case 2:
                            return '{{route('stone_save')}}';
                        case 3:
                            return '{{route('whom_save')}}';
                        case 4:
                            return '{{route('sample_save')}}';
                        case 5:
                             return '{{route('cutting_save')}}';
                    }
                },
                add_subtype(){
                    if(this.yes_subtypes===true){
                            document.getElementById('box_input_subtypes').classList.remove('d-none');
                            this.subtypes_new.push('')
                    }
                    if(this.yes_subtypes===false){
                        document.getElementById('box_input_subtypes').classList.add('d-none');
                        this.subtypes_new = [];
                    }
                },
                add_size(){
                    if(this.yes_sizes===true){
                        document.getElementById('box_input_sizes').classList.remove('d-none');
                        this.sizes_new.push('')
                    }
                    if(this.yes_subtypes===false){
                        document.getElementById('box_input_sizes').classList.add('d-none');
                        this.sizes_new =[];
                    }
                },


            },
            mounted(){
                this.getCategories()
            }
        }
        Vue.createApp(app).mount('#categories')
    </script>
@endsection
