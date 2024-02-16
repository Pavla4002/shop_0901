@extends('layout.app')
@section('title')
@endsection
@section('main')
    <div class="container-fluid w-75" id="catalog" style="margin-top: 30px">
        <div class="" style="margin-bottom: 30px">
            <h3 class="text-uppercase">Каталог товаров</h3>
        </div>
<!-- Поиск и фильты -->
<div class="">
    <div class="d-flex justify-content-sm-between w-100 align-items-center">
        <div class="d-flex flex-md-column" >
            <label for="search">Поиск</label>
            <input type="text" style="width: 300px" id="search" v-model="search" class="form-control">
        </div>
        <div class="">
            <span>Сортировка</span>
            <div class="d-flex flex-md-column">
                <label for="price">Цена</label>
                <select name="" id="price" v-model="status_price" class="form-select">
                    <option value=" " disabled selected>Сортировка по цене</option>
                    <option value="0">По убыванию</option>
                    <option value="1">По возрастанию</option>
                </select>
            </div>
        </div>

        <div class="">
            <span>Сортировка</span>
            <div class="d-flex flex-md-column">
                <label for="title">Название</label>
                <select name="" id="title" v-model="status_title" class="form-select">
                    <option value=" " disabled selected>Сортировка по названию</option>
                    <option value="0">По убыванию</option>
                    <option value="1">По возрастанию</option>
                </select>
            </div>
        </div>
    </div>

        <div id="filters" class="d-flex justify-content-sm-between flex-wrap mb-5 mt-5">
            <h4>Фильтры</h4>
            <div>
            <!-- v-model="type_filter" @change="filter_list_product(type_filter)" -->
                <select name="type_select" v-model="type_filter" class="form-select">
                    <option value=" " disabled selected>Тип</option>
                    <option :value="type.id" v-for="type in types">
                        @{{ type.title }}
                    </option>
                </select>
            </div>
            <div>
            <!-- v-model="material_filter" @change="filter_material_product(material_filter)" -->
                <select name="type_select" id="" v-model="material_filter" class="form-select">
                    <option value=" " disabled selected>Материал</option>
                    <option :value="item.id" v-for="item in materials">
                        @{{ item.title }}
                    </option>
                </select>
            </div>
            <div>
            <!--  @change="filter_sample_product(sample_filter)" -->
                <select name="type_select" id="" v-model="sample_filter" class="form-select">
                    <option value=" " disabled selected>Проба</option>
                    <option :value="item.id" v-for="item in samples">
                        @{{ item.title }}
                    </option>
                </select>
            </div>
            <div>
            <!--  @change="filter_stone_product(stone_filter)" -->
                <select name="type_select" id="" v-model="stone_filter" class="form-select">
                    <option value=" " disabled selected>Вставка</option>
                    <option :value="item.id" v-for="item in stones">
                        @{{ item.title }}
                    </option>
                </select>
            </div>
            <div>
            <!--  @change="filter_brand_product(cutting_filter)" -->
                <select name="type_select" id="" v-model="brand_filter" class="form-select">
                    <option value=" " disabled selected>Бренд</option>
                    <option :value="type.id" v-for="type in brands">
                        @{{ type.title }}
                    </option>
                </select>
            </div>
            <div class="">
                <button class="btn btn-secondary" @click="restart">
                    Сбросить фильтры
                </button>
            </div>

</div>
<!-- Поиск и фильтры -->
<!-- Каталог -->
    <div class="container-fluid d-flex justify-content-between flex-wrap">
<!--  Карточка товара-->
        <div class="d-flex flex-column align-items-center shadow" v-for="product in sortTitle" style="margin-bottom: 50px">
        <div style="position:relative; height:300px; width:300px;" >
            <div v-for="(img,index) in product.images.split(';')">
                <img v-if="index===0" :src="'/public/' + img" class="w-100 object-fit-cover" style="height: 300px; width: 300px; object-fit: cover;" alt="...">
            </div>
            <div class="" style="position:absolute; top:10px; right:10px">
                <a :href="`{{route('info_product_page')}}/${product.id}`" class="btn btn-primary">Подробнее</a>
            </div>
        </div>
        <div class="w-75 container-fluid" style="margin: 20px 0">
            <h5>@{{product.title}}</h5>
            <span><b>$ @{{product.price}}</b></span>
        </div>
            <div class="w-100 d-flex justify-content-end" style="padding: 10px">
                <!-- <button class="btn btn-danger" @click="add_to_cart(product.id)"></button> -->
                <!-- Button trigger modal -->
                <button v-if="product" type="button" class="btn btn-danger" data-bs-toggle="modal" @click="getSizesBye(product.id),sizes_bye=[]" :data-bs-target="`#exampleModal_${product.id}`">
                    В корзину +
                </button>

                <!-- Modal -->
                <div class="modal fade" :id="`exampleModal_${product.id}`" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Добавляем товар</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                        <span v-if="message !==''" :class="message !=='' ? 'alert alert-success':''" style="margin-bottom: 20px">@{{ message }}</span>
                    <div class="modal-body">
                        <!--  Форма размеров-->
                        <form @submit.prevent="add_to_cart(product.id)">
                            <span>Вам необходимо выбрать размер</span>
                                <div class="" v-if="sizes_get" v-for="size in sizes_get" style="padding: 10px" >
                                    <label :for="`size_${size.id}_${product.id}`">@{{ size.number }}</label>
                                    <input type="radio" :id="`size_${size.id}_${product.id}`" :value="size" v-model="sizes_bye">
                                </div>
                            <span>Если размеров нет, нажмите на кнопку "В корзину"</span>
                            <div class="">
                                <button type="submit" class="btn btn-danger">В корзину + </button>
                            </div>
                        </form>
                        <!--  Форма размеров-->
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
<!--  Карточка товара-->
    </div>

<!-- Каталог -->
    </div>
</div>

    <script>
        const app={
             data(){
                return{
                    oroginal_product:[],
                    // Тест фильтров
                    type_filter:' ',
                    subtype_filter:' ',
                    material_filter:' ',
                    brand_filter:' ',
                    stone_filter:' ',
                    cutting_filter:' ',
                    sample_filter:' ',
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
                    product_filial_sizes:[],
                    show_content:[],

                    //Поиск
                    search:'',
                    //

                    products:[],

                //     Сортировка
                    status_price:' ',
                    status_title:' ',
                    sizes_get:[],
                    sizes_bye:[],
                    message:'',
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
                restart(){
                    location.reload();
                },
                async get_products(){
                        let response = await fetch('{{route('get_products')}}');
                        this.products = await response.json();
                        this.oroginal_product = this.products;
                },
                
                 async add_to_cart(product_id){
           
                     let sizes=[];
                     if(this.sizes_bye!==[]){
                         sizes.push(this.sizes_bye.id)
                     }else{
                         let sizes = []
                     }

                        let response = await fetch('{{route('add_to_cart')}}',{
                        method: 'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}',
                            'Content-Type':'application/json'
                        },
                        body: JSON.stringify({
                            id:product_id,
                            size_id:sizes
                        })
                    });

                     if(response.status===200){
                        let help = await response.json();
                         this.message = help[0];
                         setTimeout(()=>{
                             this.message ='';
                         },5000)
                     }
                 },
                 getSizesBye(product_id){
                    let arr = [];
                     this.product_filial_sizes.forEach(el =>{
                         if(el.id === product_id){
                             el.product_filial_sizes.forEach(el2 =>{
                                 if(el2.size){
                                     arr.push(el2.size)
                                 }
                             })
                         }
                     });

                     this.sizes_get = Object.values(arr.reduce((acc, n) => (
                         acc[n.number] = n.checked ? n : (acc[n.number] || n), acc), {}));

                     if(this.sizes_get===[]){
                         this.sizes_bye=[1]
                     }
                 }
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
                    if(this.search!==''){
                        return this.changeEnd.filter(el=> el.material.title.toLowerCase().includes(this.search.toLowerCase()) || (el.sample?.title === this.search) || el.cutting?.title.toLowerCase().includes(this.search.toLowerCase()) || el.stone?.title.toLowerCase().includes(this.search.toLowerCase()) || (+el.price === +this.search) || el.title.toLowerCase().includes(this.search.toLowerCase()) || el.whome.title.toLowerCase().includes(this.search.toLowerCase()) || el.brand.title.toLowerCase().includes(this.search.toLowerCase()) || el.type.title.toLowerCase().includes(this.search.toLowerCase()) || el.subtype?.title.toLowerCase().includes(this.search.toLowerCase()));
                    }else{
                        return this.changeEnd
                    }
                },
                sortPrice(){
                    if(this.status_price === '1'){
                        return this.searchProduct.sort((a,b)=> +a.price > +b.price ? 1 : -1);
                    }else if(this.status_price === '0'){
                        return this.searchProduct.sort((a,b)=> +a.price < +b.price ? 1 : -1);
                    }else{
                        return this.searchProduct
                    }
                },
                sortTitle(){
                    if(this.status_title === '1'){
                        return this.sortPrice.sort((a,b)=> a.title > b.title ? 1 : -1);
                    }else if(this.status_title === '0'){
                        return this.sortPrice.sort((a,b)=> a.title < b.title ? 1 : -1);
                    }else{
                        return this.sortPrice;
                    }
                 }
             },
             mounted(){
                this.get_products();
                this.getCategories();

             }
        }
        Vue.createApp(app).mount('#catalog')
    </script>
@endsection
