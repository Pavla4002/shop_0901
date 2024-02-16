@extends('layout.app')
@section('title')
@endsection
@section('main')
    <div class="container-fluid w-75" id="info_product" style="margin-top: 30px">
        <div class="w-100 d-flex justify-content-sm-between mb-5">
            <div class="w-75 d-flex align-items-center">
                <h1>@{{ product.title }}</h1>
                <button @click="add_favorite" class="btn btn-info" style="height: 40px; margin-left: 20px" v-if="product.favorites && product.favorites.length==0">Добавить в избранное</button>
                <button class="btn" style="height: 40px; margin-left: 20px; background-color: yellow" v-if="product.favorites && product.favorites.length!==0">Фаворит</button>
            </div>

            <button class="btn btn-danger" @click="add_to_cart(product.id)">В корзину +</button>
        </div>
        <div class="d-flex justify-content-between ">
            <div class="">
                <div class="">
                    <div v-if="product.images" v-for="(img,index) in product.images.split(';')" style="width: 300px; height: 300px; margin-bottom: 30px;">
                        <img v-if="index===0" :src="'/public/' + img" class="w-100 object-fit-cover" style="height: 100%; width: 100%; object-fit: cover;" alt="...">
                    </div>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-secondary w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Добваить отзыв
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
{{--                                   Форма --}}
                                    <form id="reviews_add" @submit.prevent="add_reviews">
                                        <div class="mb-3">
                                            <label for="positive" class="form-label">Достоинства</label>
                                            <input type="text" class="form-control" id="positive" name="positive">
                                        </div>
                                        <div class="mb-3">
                                            <label for="negative" class="form-label">Недостатки</label>
                                            <input type="text" class="form-control" id="negative" name="negative">
                                        </div>
                                        <div class="mb-3">
                                            <label for="text" class="form-label">Отзыв</label>
                                            <input type="text" class="form-control" id="text" name="text">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Отправить</button>
                                    </form>
{{--                                    Форма--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-md-column justify-content-start" style="margin-left: 70px">
                <h4 style="margin-bottom: 20px">$ @{{ product.price }}</h4>
                <span v-if="product.material" style="margin-bottom: 20px">Материал: @{{ product.material.title }}</span>
                <span v-if="product.type" style="margin-bottom: 20px">Тип товара: @{{ product.type.title }}</span>
                <span v-if="product.subtype" style="margin-bottom: 20px">Подтип товара: @{{ product.subtype.title }}</span>
                <span v-if="product.stone" style="margin-bottom: 20px">Вставка: @{{ product.stone.title }}</span>
                <span v-if="product.cutting" style="margin-bottom: 20px">Огранка: @{{ product.cutting.title }}</span>
                <span v-if="product.brand" style="margin-bottom: 20px">Бренд: @{{ product.brand.title }}</span>
                <span v-if="product.sample" style="margin-bottom: 20px">Проба: @{{ product.sample.title }}</span>
            </div>
            <div  style="width: 400px;">
                <span>@{{ product.description }}</span>
            </div>
        </div>
        <div class="d-flex justify-content-center align-items-center text-bg-light w-100 mt-5" style="width: 700px; height: 40px">
            <h4 class="text-uppercase">Отзывы о продукте</h4>
        </div>
        <div class="mt-5 mb-5 d-flex flex-wrap" >
            <div class="bg-body-secondary"  v-for="rev in reviews" style="width: 300px; padding: 15px; margin-left: 20px; margin-bottom: 20px">
                <div v-if="rev.user"><b>@{{rev.user.fio}}</b></div>
                <div>Явные достоитства: @{{rev.positive}}</div>
                <div>Явные недостатки: @{{rev.negative}}</div>
                <div><span>Отзыв: @{{ rev.text }}</span></div>
            </div>
        </div>
        </div>

        <script>
            const app={
                data(){
                    return{
                        products:[],
                        product:{ },
                        id_pro:'',
                        reviews:[],

                    //     куча инфы
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
                        show_content:[]
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
                    async add_to_cart(product_id){
                        let response = await fetch('{{route('add_to_cart')}}',{
                            method: 'post',
                            headers:{
                                'X-CSRF-TOKEN':'{{csrf_token()}}',
                                'Content-Type':'application/json'
                            },
                            body: JSON.stringify({
                                id:product_id
                            })
                        });
                    },
                    get_product_url(){
                        let url = window.location.href;
                        let id_arr = url.split('/');
                        this.id_pro = id_arr[id_arr.length-1];
                        this.get_need_product(this.id_pro);
                        // this.product = this.products.find(el=>+el.id===+id);
                        // console.log(this.product);
                    },
                    async get_reviews(){
                        let id_product = this.product.id;
                        console.log(id_product)
                        let response = await fetch('{{route('get_reviews')}}',{
                            method:'post',
                            headers:{
                                'X-CSRF-TOKEN':'{{csrf_token()}}',
                                'Content-Type':'application/json'
                            },
                            body: JSON.stringify({
                                id_product:id_product,
                            })
                        });
                        this.reviews = await response.json();
                        console.log(  this.reviews)
                    },
                    async get_need_product(id_pro){
                        let response = await fetch('{{route('get_need_product')}}',{
                            method:'post',
                            headers:{
                                'X-CSRF-TOKEN':'{{csrf_token()}}',
                                'Content-Type':'application/json'
                            },
                            body: JSON.stringify({
                                id_product:id_pro,
                            })
                        });
                        this.product = await response.json();
                        console.log( this.product )
                        this.get_reviews()
                    },

                    async add_reviews(){
                        let form = document.getElementById('reviews_add');
                        let data = new FormData(form);
                        data.append('id', this.product.id)
                        let response = await fetch('{{route('add_reviews')}}',{
                            method:'post',
                            headers:{
                                'X-CSRF-TOKEN':'{{csrf_token()}}',
                                // 'Content-Type':'application/json'
                            },
                            body: data
                        })

                        if(response.status === 200){
                            this.reviews = await response.json();
                            form.reset();
                        }
                    },
                    async add_favorite(){
                        let id_product = this.product.id;
                        let response = await fetch('{{route('add_favorite')}}',{
                            method:'post',
                            headers:{
                                'X-CSRF-TOKEN':'{{csrf_token()}}',
                                'Content-Type':'application/json'
                            },
                            body: JSON.stringify({
                                id_product:id_product,
                            })
                        })
                        if(response.status===200){
                            this.product = await response.json();
                            location.reload();
                        }
                    }
                },
                computed:{

                },
                mounted(){
                    this.get_product_url()
                    this.getCategories()

                }
            }
            Vue.createApp(app).mount('#info_product')
        </script>
@endsection
