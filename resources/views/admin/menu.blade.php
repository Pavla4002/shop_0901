@extends('layout.app')
@section('title')
    Админ.Филиалы
@endsection
@section('main')
    <div class="container-fluid w-75" id="all_orders">
        <div class="mt-3"><a href="{{route('filials')}}">Филиалы</a></div>
        <div class="mt-3"><a href="{{route('index_admin')}}">Характеристики</a></div>
        <div class="mt-3"><a href="{{route('product_index')}}">Продукты</a></div>
        <div class="d-flex mt-3">
            <a href="{{route('orders_page')}}">Заказы</a>
            <div class="text-white d-flex justify-content-center align-items-center" style="background-color:red; width:20px; height:20px; border-radius:50%; margin-left:7px">
                    @{{count_orders}}
            </div>
        </div>
    </div>
    <script>
        const app = {
            data(){
                return{
                    all_orders: [],
                    count_orders: 0,
                }
            },
            methods:{
                async getAllOrders(){
                    let response = await fetch('{{route('get_all_orders')}}');
                    this.all_orders = await response.json();
                    this.count_orders = this.all_orders.length;
                }
            },
            computed:{

            },
            mounted(){
                this.getAllOrders();
            }
        }
        Vue.createApp(app).mount('#all_orders');
    </script>
@endsection
