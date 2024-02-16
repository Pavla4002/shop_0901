@extends('layout.app')
@section('title')
    Админ.Филиалы
@endsection
@section('main')
    <div class="container-fluid w-75" id="orders">
        <h1>Заказы пользователей</h1>
        <div class="">
            <!--  -->
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Сумма</th>
                        <th scope="col">Филиал</th>
                        <th scope="col">Дата начала</th>
                        <th scope="col">Изменение статуса</th>
                    </tr>
                </thead>
                    <tbody>
                        <tr v-for="order in all_orders">
                            <th scope="row">@{{order.id}}</th>
                            <td>@{{order.status}}</td>
                            <td>$@{{order.sum}}</td>
                            <td v-if="order.filial">@{{order.filial.title}}</td>
                            <td v-else="order.filial.length===0">Я забыла</td>
                            <td>@{{order.date_start}}</td>
                            <td style="width:400px">
                                <button class="btn btn-primary">Подтвердить</button>
                                <button class="btn btn-danger">Отклонить</button>
                            </td>
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
                    all_orders: [],
                    }
            },
            methods:{
                async getAllOrders(){
                    let response = await fetch('{{route('get_all_orders')}}');
                    this.all_orders = await response.json();
                }
            },
            computed:{

            },
            mounted(){
                this.getAllOrders();
            }
        }
        Vue.createApp(app).mount('#orders');
    </script>
@endsection
