@extends('layout.app')
@section('title')
@endsection
@section('main')
    <div class="container-fluid w-75" id="user_orders" style="margin-top: 30px">
        <div class="">
           <h1>Заказы</h1>
        </div>
        <div class="">
<!--  -->
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Филиал</th>
                        <th scope="col">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="order in orders">
                        <th scope="row">@{{order.id}}</th>
                        <td>@{{order.status}}</td>
                        <td v-if="order.filial">@{{order.filial.title}}</td>
                        <td v-else="order.filial.length==0">забыла филиал</td>
                        <td>$@{{order.sum}}</td>
                    </tr>
                </tbody>
            </table>
<!--  -->
        </div>
    </div>

    <script>
        const app={
             data(){
                return{
                    orders:[],
                }
             },
             methods:{
                async getOrders(){
                    let response = await fetch('{{route('get_orders_user')}}');
                    this.orders = await response.json();
                }
             },
             computed:{

             },
             mounted(){
                this.getOrders();
             }
        }
        Vue.createApp(app).mount('#user_orders')
    </script>
@endsection
