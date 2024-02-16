@extends('layout.app')
@section('title')
    Админ.Товары
@endsection
@section('main')
    <div class="container-fluid w-75" id="products">
        <div class="w-100 d-flex justify-content-sm-between align-items-center">
            <h1>Товары</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal_2">
                Создать
            </button>
        </div>
        <div>
            <!-- {{--        Модальное окно--}} -->
            <div class="modal fade" id="exampleModal_2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Создание нового товара</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="PushData()" id="form_product" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"><b>Введите наименование товара</b></label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Введите описание товара</label>
                                    <textarea type="text" class="form-control" id="exampleInputPassword1" name="description"></textarea>
                                </div>
                                <div>
                                    <label for="img">Добавьте изображения товара</label>
                                    <input class="form-control" type="file" name="images[]" multiple id="img">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"><b>Введите цену товара</b></label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="price">
                                </div>
                                <div class="mb-3 w-100 d-flex flex-md-column">
                                    <label for="exampleInputEmail1" class="form-label"><b>Введите тип товара</b></label>
                                    <select class="form-select" name="select_type" @change="select_type()" id="select_type">
                                        <option value="type" disabled selected>Выбери тип</option>
                                        <option :value="type.id" v-for="type in types">@{{ type.title }}</option>
                                    </select>
                                </div>
                                <!-- {{--    Информация о подтипах и размерах    --}} -->
                                <div v-if="type_sub_info.length>0" class="mb-3 w-100 d-flex flex-md-column">
                                    <b>Выберите подтип</b>
                                    <div>
                                        <select name="subtype" id="sub_type">
                                            <option value="" disabled selected>У вас есть выбор</option>
                                            <option :value="sub.id" v-for="sub in type_sub_info">@{{ sub.title }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div v-if="type_size_info.length>0" class="mb-3 w-100 d-flex flex-md-column">
                                    <b>Выберите размер</b>
                                    <div class="" style="display: flex; justify-content: start; flex-wrap: wrap">
                                        <div v-for="size in type_size_info" class="m-lg-3">
                                            <label for="">@{{ size.number }}</label>
                                            <input type="checkbox" :value="size.number" @change="select_size_check(size.id)" :id="'size_' + size.id">
                                        </div>
                                    </div>
                                </div>
                                <!-- {{--    Информация о подтипах и размерах    --}} -->
                                <div class="mb-3 w-100 d-flex flex-md-column">
                                    <label for="exampleInputEmail1" class="form-label"><b>Введите тип материала</b></label>
                                    <select class="form-select" name="select_material">
                                        <option value="" disabled selected>Выбери материал</option>
                                        <option :value="material.id" v-for="material in materials">@{{ material.title }}</option>
                                    </select>
                                </div>
                                <div class="mb-3 w-100 d-flex flex-md-column">
                                    <label for="exampleInputEmail1" class="form-label"><b>Введите пол носителя</b></label>
                                    <select class="form-select" name="select_whome">
                                        <option value="" disabled selected>Выбери носителя</option>
                                        <option :value="whome.id" v-for="whome in whomes">@{{ whome.title }}</option>
                                    </select>
                                </div>
                                <div class="mb-3 w-100 d-flex flex-md-column">
                                    <label for="exampleInputEmail1" class="form-label"><b>Введите вставку</b></label>
                                    <select class="form-select" name="select_stone">
                                        <option value="" disabled selected>Выбери вставку</option>
                                        <option :value="stone.id" v-for="stone in stones">@{{ stone.title }}</option>
                                    </select>
                                </div>
                                <div class="mb-3 w-100 d-flex flex-md-column">
                                    <label for="exampleInputEmail1" class="form-label"><b>Введите огранку</b></label>
                                    <select class="form-select" name="select_cutting">
                                        <option value="" disabled selected>Выбери огранку</option>
                                        <option :value="cutting.id" v-for="cutting in cuttings">@{{ cutting.title }}</option>
                                    </select>
                                </div>
                                <div class="mb-3 w-100 d-flex flex-md-column">
                                    <label for="exampleInputEmail1" class="form-label"><b>Введите бренд</b></label>
                                    <select class="form-select" name="select_brand">
                                        <option value="" disabled selected>Выбери бренд</option>
                                        <option :value="brand.id" v-for="brand in brands">@{{ brand.title }}</option>
                                    </select>
                                </div>
                                <div class="mb-3 w-100 d-flex flex-md-column">
                                    <label for="exampleInputEmail1" class="form-label"><b>Введите пробу</b></label>
                                    <select class="form-select" name="select_sample">
                                        <option value="" disabled selected>Выбери пробу</option>
                                        <option :value="sample.id" v-for="sample in samples">@{{ sample.title }}</option>
                                    </select>
                                </div>
                                <div>
                                    <span><b>Выберите филиалы, в которые завезут товар</b></span>
                                    <div v-for="filial in filials" class="d-flex justify-content-sm-between align-items-center mb-2 mt-2">
                                        <div>
                                            <label for="">@{{filial.title}}</label>
                                            <input type="checkbox" :id="'filial_title_' + filial.id" @change="check_filials(filial.id)">
                                        </div>
                                        <div class="d-flex flex-md-column" v-if="potential_sizes.length>0" style="width: 300px">
                                            <div v-for="size in potential_sizes" class="d-flex justify-content-sm-between align-items-center">
                                                <div>
                                                    <label for="">@{{ size.info }}</label>
                                                    <input type="checkbox" :id="'number_size_' + size.id + filial.id" @change="check_size_in_filial(filial.id, size.id)" :value="size.info">
                                                </div>
                                                <div class="d-flex flex-md-column">
                                                    <!-- {{--   Тут не доделано, только id   --}} -->
                                                    <label for="count_product">Кол-во товара</label>
                                                    <input type="text" :id="'count_product_' + size.id + filial.id" @change="number_check(filial.id, size.id)">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- {{--   Тут не доделано   --}} -->
                                        <div v-else class="d-flex flex-md-column">
                                            <label for="count_product_1">Введите кол-во товара</label>
                                            <input type="text" :id="'count_product_' + filial.id" @change="number_check(filial.id)">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Создать</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- {{--         Модальное окно--}} -->
        </div>
        <div class="d-flex flex-md-column">
                <label for="search">Поиск</label>
                <input type="text" style="width: 300px" id="search" v-model="search">
        </div>
        <div id="filters" class="d-flex justify-content-sm-between flex-wrap mb-5 mt-5">
            <h4>Фильтры</h4>
            <div>
            <!-- v-model="type_filter" @change="filter_list_product(type_filter)" -->
                <select name="type_select" v-model="type_filter">
                    <option value=" " disabled selected>Тип</option>
                    <option :value="type.id" v-for="type in types">
                        @{{ type.title }}
                    </option>
                </select>
            </div>
            <div>
            <!-- v-model="subtype_filter" @change="filter_subtype_product(subtype_filter)" -->
                <select name="type_select" v-model="subtype_filter">
                    <option value=" " disabled selected>Подтип</option>
                    <option :value="item.id" v-for="item in subtypes">
                        @{{ item.title }}
                    </option>
                </select>
            </div>
            <div>
            <!-- v-model="material_filter" @change="filter_material_product(material_filter)" -->
                <select name="type_select" id="" v-model="material_filter">
                    <option value=" " disabled selected>Материал</option>
                    <option :value="item.id" v-for="item in materials">
                        @{{ item.title }}
                    </option>
                </select>
            </div>
            <div>
            <!--  @change="filter_sample_product(sample_filter)" -->
                <select name="type_select" id="" v-model="sample_filter">
                    <option value=" " disabled selected>Проба</option>
                    <option :value="item.id" v-for="item in samples">
                        @{{ item.title }}
                    </option>
                </select>
            </div>
            <div>
            <!--  @change="filter_stone_product(stone_filter)" -->
                <select name="type_select" id="" v-model="stone_filter">
                    <option value=" " disabled selected>Вставка</option>
                    <option :value="item.id" v-for="item in stones">
                        @{{ item.title }}
                    </option>
                </select>
            </div>
            <div>
            <!--  @change="filter_cutting_product(cutting_filter)" -->
                <select name="type_select" id="" v-model="cutting_filter">
                    <option value=" " disabled selected>Огранка</option>
                    <option :value="item.id" v-for="item in cuttings">
                        @{{ item.title }}
                    </option>
                </select>
            </div>
            <div>
            <!--  @change="filter_brand_product(cutting_filter)" -->
                <select name="type_select" id="" v-model="brand_filter">
                    <option value=" " disabled selected>Бренд</option>
                    <option :value="type.id" v-for="type in brands">
                        @{{ type.title }}
                    </option>
                </select>
            </div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Картинка</th>
                    <th scope="col">Название</th>
                    <th scope="col">Цена</th>
                    <th scope="col">Характеристики</th>
                    <th scope="col">Действия</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="product in searchProduct">
                        <th scope="row">@{{product.id}}</th>
                        <td style="width: 400px; height: 350px">
                            <div :id="`carouselExample_${product.id}`" class="carousel slide">
                                <div class="carousel-inner">
                                    <div class="carousel-item active h-100" v-for="(img,index) in product.images.split(';')" :class="index===0 ? 'active':''">
                                        <img :src="'/public/' + img" class=" w-100 object-fit-cover" style="height: 250px; width: 300px" alt="..." v-if="img!=''">
                                    </div>
                                </div>
                                <button class="carousel-control-prev" type="button" :data-bs-target="`#carouselExample_${product.id}`" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" :data-bs-target="`#carouselExample_${product.id}`" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </td>
                        <td>@{{product.title}}</td>
                        <td>$ @{{product.price}}</td>
                        <td>
                            <ul>
                                <li>@{{product.material.title}}</li>
                                <li v-if="product.sample">@{{product.sample.title}}</li>
                                <li v-if="product.stone">@{{product.stone.title}}</li>
                                <li v-if="product.cutting">@{{product.cutting.title}}</li>
                                <li>@{{product.whome.title}}</li>
                                <li>@{{product.type.title}}</li>
                                <li v-if="product.subtype">@{{product.subtype.title}}</li>
                                <li>@{{product.brand.title}}</li>
                            </ul>
                        </td>
                        <td>
                            <a :href="`{{route('delete_product')}}/${product.id}`" class="btn btn-danger">Удалить</a>
                            <a href="#" class="btn btn-primary">Редактировать</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        const app ={
            data(){
                return{
                    yes:'',
                    // Тест фильтров
                    type_filter:' ',
                    subtype_filter:' ',
                    material_filter:' ',
                    brand_filter:' ',
                    stone_filter:' ',
                    cutting_filter:' ',
                    sample_filter:' ',
                    //

                    //Поиск
                    search:' ',
                    //

                    data:[],
                    types:[],
                    subtypes:[],
                    stones:[],
                    cuttings:[],
                    whomes:[],
                    materials:[],
                    samples:[],
                    brands:[],
                    filials:[],

                    type_product:'',
                    //Получение информации о типе
                    type_select_id:'',
                    type_sub_info:[],
                    type_size_info:[],

                    potential_sizes:[],
                    potential_filials:[],
                    sizes_in_filials:[],
                    potential_info:{
                        filials:[],
                        info:[]
                    },
                    pre_end_info:[],
                    end_array:[],


                    product_filial_sizes:[],
                    show_content:[],
                }
            },
            methods:{
                async getCategories(){
                    let response_type = await fetch('{{route('get_type')}}');
                    let response_subtype = await fetch('{{route('get_subtype')}}');
                    let response_stones = await fetch('{{route('get_stone')}}');
                    let response_cuttings = await fetch('{{route('get_cutting')}}');
                    let response_whomes = await fetch('{{route('get_whom')}}');
                    let response_materials = await fetch('{{route('get_material')}}');
                    let response_samples = await fetch('{{route('get_sample')}}');
                    let response_brands =  await fetch('{{route('get_brand')}}');
                    let response_filials = await fetch('{{route('get_filial')}}');
                    let response_size_filial = await fetch('{{route('get_filial_sizes')}}');
                    this.filials = await response_filials.json();

                    this.product_filial_sizes = await response_size_filial.json()
                    this.show_content = this.product_filial_sizes;
                    this.types = await response_type.json();
                    this.subtypes = await response_subtype.json();
                    this.stones = await response_stones.json();
                    this.cuttings = await response_cuttings.json();
                    this.whomes = await response_whomes.json();
                    this.materials = await response_materials.json();
                    this.samples = await response_samples.json();
                    this.brands = await response_brands.json();
                    this.data = this.types;
                },
                select_type(){
                    this.type_sub_info = [];
                    this.type_size_info = [];
                    this.potential_sizes.forEach(el =>{
                        let size = document.getElementById('size_' + +el);
                        size.checked=false
                    })
                    this.potential_sizes=[];

                    let select_t = document.getElementById('select_type');
                    this.type_select_id = select_t.value;
                    this.types.forEach(type => {
                        if(type.id === +this.type_select_id){
                            if(type.subtypes.length>0){
                                this.type_sub_info = type.subtypes;
                            }
                            if(type.sizes.length>0){
                                this.type_size_info = type.sizes;
                            }
                        }
                    })
                },
                select_size_check(id){
                    let size = document.getElementById('size_' + id);
                    if(size.checked === true){
                        let obj_size = {'id':id, 'info': size.value}
                        this.potential_sizes.push(obj_size);
                    }else{
                        this.potential_sizes.forEach((el,index) => {
                            if(+el.id===+id){
                                this.potential_sizes.splice(index,1);
                            }
                        })
                    }
                },
                async PushData(){
                    let form = document.getElementById('form_product');
                    let form_data = new FormData(form);
                    let response = await fetch('{{route('store_product')}}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        },
                        body:form_data
                    })

                    if(response.status ===200){
                        let data_response = await response.json();
                        let product_id = data_response.product_id;

                        let obj ={}
                        console.log(this.end_array[0].info)
                        if(this.end_array[0].info){
                            obj ={
                                product_id:product_id,
                                product_filial_size: this.end_array,
                                info:[1]
                            }
                        }else{
                            obj ={
                                product_id:product_id,
                                product_filial_size: this.end_array,
                                info:[]
                            }
                            console.log('no');
                            console.log(this.end_array);
                        }

                        const response_PFS = await fetch('{{route('saveNewPFS')}}',{
                            method:'post',
                            headers:{
                                'X-CSRF-TOKEN':'{{csrf_token()}}',
                                'Content-Type':'application/json'
                            },
                            body: JSON.stringify(obj)
                        })
                    }
                },
                //сохранение чекнутых филиалов
                check_filials(id_filial){
                    this.potential_filials =[];
                    this.potential_info ={
                        filials:[],
                        info:[]
                    }
                    let filial_checked = document.getElementById('filial_title_' + id_filial);
                    if(filial_checked.checked === true){
                        this.potential_filials.push(id_filial);
                    }else{
                        this.potential_filials.forEach((el, index) => {
                            if(+el === +id_filial){
                                this.potential_filials.splice(index,1);
                            }
                        })
                    }
                    if(this.potential_filials.length>0){
                        this.potential_info.filials = this.potential_filials;
                    }
                },
                check_size_in_filial(filial_id, size_id){
                    let size_in_filial = document.getElementById('number_size_' + size_id + filial_id);
                    if(size_in_filial.checked === true){
                        this.potential_info.filials.forEach((el) => {
                            if(+el === +filial_id){
                                let count_size = document.getElementById('count_product_' + size_id + filial_id);
                                let info_count_size = {
                                    'count': +count_size.value,
                                    'size': size_id
                                }
                                this.potential_info['info'].push(info_count_size);
                                if(count_size.value!==''){
                                    this.number_check(filial_id,size_id)
                                }
                            }
                        })
                    }else{
                        this.potential_info.info.forEach((el, index) => {
                            if(+el.size === +size_id){
                                this.potential_info['info'].splice(index,1);
                                document.getElementById('count_product_' + size_id + filial_id).value = '';
                            }
                        })
                    }
                },
                number_check(filial_id, size_id){
                    if(this.potential_info.info.length>0){
                        if(size_id){
                            this.potential_info.info.forEach(el => {
                                if(el.size === size_id){
                                    let count_size = document.getElementById('count_product_' + size_id + filial_id);
                                    el.count = +count_size.value;
                                }
                            })
                            console.log(this.potential_info)
                            let mas = this.potential_info
                            if(this.end_array.length>0){
                                let el = this.end_array.find(el => el.filials[0] === filial_id);
                                if(el){

                                }else{
                                    this.end_array.push(mas);
                                }
                            }else{
                                this.end_array.push(mas);
                            }

                        }
                    }else{
                        let count_size = document.getElementById('count_product_' + filial_id);
                        let obj = {
                            'filials':filial_id,
                            'count': count_size.value
                        }
                        this.end_array.push(obj)
                    }
                },
            },
            computed:{
                changeFilterType(){
                    if(this.type_filter!==' '){
                        return this.show_content.filter(el => el.type_id == this.type_filter);
                    }
                    return this.show_content
                },
                changeFilterSub(){
                    if(this.subtype_filter!==' '){
                        return this.changeFilterType.filter(el => el.subtype_id == this.subtype_filter);
                    }
                   return this.changeFilterType
                },
                changeFilterMaterial(){
                    if(this.material_filter!==' '){
                        return this.changeFilterSub.filter(el => el.material_id == this.material_filter);
                    }
                    return this.changeFilterSub
                },
                changeFilterSample(){
                    if(this.sample_filter!==' '){
                        return this.changeFilterMaterial.filter(el => el.sample_id == this.sample_filter);
                    }
                    return this.changeFilterMaterial
                },
                changeFilterStone(){
                    if(this.stone_filter!==' '){
                        return this.changeFilterSample.filter(el => el.stone_id == this.stone_filter);
                    }
                    return this.changeFilterSample
                },
                changeFilterCutting(){
                    if(this.cutting_filter!==' '){
                        return this.changeFilterStone.filter(el => el.cuttimg_id == this.cutting_filter);
                    }
                    return this.changeFilterStone
                },
                changeEnd(){
                    if(this.brand_filter!==' '){
                        return this.changeFilterCutting.filter(el => el.brand_id == this.brand_filter);
                    }
                    return this.changeFilterCutting
                },
                searchProduct(){
                    if(this.search!==' '){
                        return this.changeEnd.filter(el=> el.material.title.toLowerCase().includes(this.search.toLowerCase()) || (+el.sample?.title === +this.search) || el.cutting?.title.toLowerCase().includes(this.search.toLowerCase()) || el.stone?.title.toLowerCase().includes(this.search.toLowerCase()) || (+el.price === +this.search) || el.title.toLowerCase().includes(this.search.toLowerCase()) || el.whome.title.toLowerCase().includes(this.search.toLowerCase()) || el.brand.title.toLowerCase().includes(this.search.toLowerCase()) || el.type.title.toLowerCase().includes(this.search.toLowerCase()) || el.subtype?.title.toLowerCase().includes(this.search.toLowerCase()));
                    }else{
                        return this.changeEnd
                    }
                }
            },
            mounted(){
                this.getCategories()
            }
        }
        Vue.createApp(app).mount('#products')
    </script>
@endsection
