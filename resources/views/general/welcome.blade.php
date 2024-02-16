@extends('layout.app')
@section('title')
    Главная
@endsection
@section('main')
    <div id="main_page" style="width: 90%; margin-top: 30px" class="container-fluid">
{{--        Новые акции--}}
        <div class="container-fluid" style="width: 100%">
            <div class="" style="display: flex; justify-content:space-between;">
                <div class="" style="margin-top: 50px;">
                    <h3>Интернет-магазин ювелирных изделий</h3>
                    <h1>"Ювелирка"</h1>

                    <ul style="margin-top: 50px">
                        <li>Качество</li>
                        <li>Индивидуальный подход</li>
                        <li>Новинки</li>
                        <li>Заманчивые акции</li>
                    </ul>
                </div>
                <div class="w-50" style="display: flex; justify-content:space-between; flex-wrap: wrap;">

                        <div class="" style="width: 300px; height: 250px; margin-bottom: 55px; position: relative">
                            <img src="public/my_images/браслетик.jpg" alt="" style="width: 100%; height: 100%; object-fit: cover">
                            <div class="w-100 d-flex justify-content-center p-3" style="position: absolute; bottom: 0; background-color:rgba(255,255,255,0.48); height: 100px">
                                <span style="font-size: 20px">Акция 1</span>
                            </div>
                        </div>
                        <div class="" style="width: 300px; height: 250px; margin-bottom: 55px; position: relative">
                            <img src="public/my_images/кольцо1.jpg" alt="" style="width: 100%; height: 100%; object-fit: cover">
                            <div class="w-100 d-flex justify-content-center p-3" style="position: absolute; bottom: 0; background-color:rgba(255,255,255,0.48); height: 100px">
                                <span style="font-size: 20px">Акция 1</span>
                            </div>
                        </div>


                        <div class="" style="width: 300px; height: 250px; margin-bottom: 55px; position: relative">
                            <img src="public/my_images/кольцо2.jpg" alt="" style="width: 100%; height: 100%; object-fit: cover">
                            <div class="w-100 d-flex justify-content-center p-3" style="position: absolute; bottom: 0; background-color:rgba(255,255,255,0.48); height: 100px">
                                <span style="font-size: 20px">Акция 1</span>
                            </div>
                        </div>
                        <div class="" style="width:300px; height: 250px; margin-bottom: 55px; position: relative">
                            <img src="public/my_images/6124834315.jpg" alt="" style="width: 100%; height: 100%; object-fit: cover">
                            <div class="w-100 d-flex justify-content-center p-3" style="position: absolute; bottom: 0; background-color:rgba(255,255,255,0.48); height: 100px">
                                <span style="font-size: 20px">Акция 1</span>
                            </div>
                        </div>

                </div>
            </div>
        </div>
{{--        Новые акции--}}



        <div class="d-flex justify-content-center mb-4" style="margin-top: 40px">
            <div class="d-flex justify-content-center align-items-center text-bg-light" style="width: 700px; height: 40px">
                    <h4 class="text-uppercase">Новые продукты</h4>
            </div>
        </div>
        <div class="d-flex justify-content-between container-fluid" style="width: 90%">
<!-- Карточка НОВЫЕ ПРОДУКТЫ-->
            <div class="" id="cards_block" v-for="product in products">
            <div class="card" style="width: 18rem;">
                                <div class="carousel-inner">
                                    <div class="h-100" v-for="(img,index) in product.images.split(';')" >
                                        <img v-if="index===0" :src="'/public/' + img" class=" w-100 object-fit-cover" style="height: 250px; width: 300px" alt="..." v-if="img!=''">
                                    </div>
                                </div>
                <div class="card-body">
                    <p class="card-text">@{{product.title}}</p>
                    <p>@{{product.description}}</p>
                    <span><b>@{{product.price}} $</b></span>
                </div>
            </div>
            </div>
<!-- Конец карточки -->
        </div>
        <!--Просмотреть каталог  -->
        <div class="w-100 d-flex justify-content-center mt-4">
            <a href="{{route('catalog_page')}}" class="btn btn-primary">Каталог...</a>
        </div>
        <!-- Просмотреть каталог  -->
<!--  Топ продуктов-->
        <div class="">
            <div class="container-fluid">
                    <h3>Топ продуктов</h3>
            </div>
            <!--  слайдер ТОП ПРОДУКТОВ-->
            <div id="carouselExampleDark" class="carousel carousel-dark slide" style="height:600px">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                    <div class="carousel-item" data-bs-interval="10000" v-for="(product, index) in top_products" :class="index===0 ? 'active': ''">
                    <div v-for="(img,index) in product.images.split(';')" style="height:600px">
                        <img v-if="index===0" :src="'/public/' + img" class="w-100 object-fit-cover" style="height: 100%; width: 100%; object-fit: cover;" alt="..." v-if="img!=''">
                    </div>
                    <div class="carousel-caption d-none d-md-block container-fluid" style="width:200px; height:100px; background-color: white">
                        <h5>@{{product.title}}</h5>
                    </div>
                    </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            </div>
            <!--  слайдер-->
        </div>
<!--  Топ продуктов-->
    </div>
    <script>
        const app={
                data(){
                    return{
                        products:[],
                        top_products:[],
                    }
                },
                methods:{
                    async get_products(){
                        let response = await fetch('{{route('get_products')}}');
                        this.products = await response.json();
                    },
                    async get_top_product(){ //ВЫБИРАЕМ ТОПОВЫЕ ПРОДУКТЫ
                        let response = await fetch('{{route('get_top_products')}}');
                        this.top_products = await response.json();
                        console.log(this.top_products)
                    }
                },
                computed:{

                },
                mounted(){
                    this.get_products();
                    this.get_top_product();
                }
        }
        Vue.createApp(app).mount('#main_page');
    </script>
@endsection
