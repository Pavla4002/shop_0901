@extends('layout.app')
@section('title')
@endsection
@section('main')
    <div class="container-fluid w-75" id="cart" style="margin-top: 30px">
        <div class="d-flex justify-content-sm-between w-100" style="margin-bottom: 30px;">
            <h3 class="text-uppercase">Корзина</h3>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" v-if="products.length!==0">
                Оформить заказ
            </button>
            <a href="{{route('catalog_page')}}" class="btn btn-danger" v-if="products.length===0">Каталог</a>
            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Оформление заказа</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
{{--                           --}}
                                <form @submit.prevent="sent_order()" id="password_form">
                                    <div class="mb-3">
                                        <span>Выберите филиал: </span>
                                    </div>
                                    <div class="mb-3" v-for="flial in flials">
                                        <label for="password" class="form-label">@{{flial.title}}</label>
                                        <input type="radio" class="" id="password" :value="flial.id" name="filial">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Оформить заказ</button>
                                </form>
{{--                            --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div :class="message!=='' ? 'alert alert-danger' : ''">
            @{{message}}
        </div>

        <!-- Таблица -->

        <div class="" v-if="products.length!==0">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Название</th>
                    <th scope="col">Стоимость</th>
                    <th scope="col">Размер</th>
                    <th scope="col">Количество</th>
                    <th scope="col">Удалить</th>
                    </tr>
                </thead>
                    <tbody>
                        <tr  v-for="product in products">
                        <th scope="row">@{{product.product_id}}</th>
                        <td v-if="product.product">@{{product.product.title}}</td>
                        <td v-if="product.product">@{{product.product.price}}</td>
                        <td v-if="product.size">@{{product.size.number}}</td>
                        <td v-else>нет</td>
                        <td style="width:150px; display:flex; justify-content:space-between; align-items: center">
                            <button class="btn btn-secondary" @click="minus_product(product.product_id, product.size_id)">-</button>
                                <span>
                                    @{{product.count}}
                                </span>
                            <button @click="add_to_cart(product.product_id, product.size_id)" class="btn btn-secondary">+</button>
                        </td>
                        <td>
                            <button @click="delete_cart(product.product_id, product.size_id)" class="btn btn-danger">Удалить</button>
                        </td>
                        </tr>
                    </tbody>
            </table>
        </div>
        <!-- Таблица -->
        <div class="d-flex w-100 justify-content-center" v-if="products.length===0">
            <h3>Корзина пуста</h3>
        </div>
</div>

    <script>
        const app={
             data(){
                return{
                    products:[],
                    sizes_bye:[],
                    message:'',
                    answer:'',
                    filials:[],
                }
             },
             methods:{
                async get_products_cart(){
                        let response = await fetch('{{route('get_products_cart')}}');
                        this.products = await response.json();
                    },
                 async add_to_cart(product_id, size_id){
                        let sizes=[];
                        if(size_id){
                            sizes.push(size_id);
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
                        let result=await response.json();
                        if(result!=='Больше нельзя добавить продукт в корзину'){
                                this.products = result[1];
                        }else{
                            console.log(result)
                            this.message = result;
                            setTimeout(()=>{
                                this.message ='';
                            },5000)
                        }
                     }
                },

                 async minus_product(product_id, size_id){
                     let sizes=[];
                     if(size_id){
                         sizes.push(size_id);
                     }
                     let response = await fetch('{{route('minus_product')}}',{
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
                         this.products = await response.json();
                     }
                 },
                 async delete_cart(product_id, size_id){
                     let sizes=[];
                     if(size_id){
                         sizes.push(size_id);
                     }
                     let response = await fetch('{{route('delete_cart')}}',{
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
                         this.products = await response.json();
                     }
                 },

                 async sent_order(){
                    let form = document.getElementById('password_form');
                    let data = new FormData(form);

                    let response = await fetch('{{route('user_sent_order')}}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}',
                        },
                        body:data
                    });

                    if(response.status===200){
                    {{--    this.answer = await response.json();--}}
                    {{--    let response2 = await fetch('{{route('order_sent_close')}}');--}}
                    {{--    if(response2.status===200){--}}
                        this.products= await response.json();
                    }
                 },
                 async getFilials(){
                        let response = await fetch('{{route('get_filials')}}');
                        this.flials = await response.json();
                 }
             },
             computed:{

             },
             mounted(){
                this.get_products_cart();
                this.getFilials();
             }
        }
        Vue.createApp(app).mount('#cart')
    </script>
@endsection
