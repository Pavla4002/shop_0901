@extends('layout.app')
@section('title')
    Авторизация
@endsection
@section('main')
    <div class="container-fluid w-75" id="Auth">
        <div :class="no_user ? 'alert alert-success':''">
            @{{ no_user }}
        </div>
        <form id="form_auth" @submit.prevent="Auth">
            <div class="mb-3">
                <label for="login" class="form-label">Введите адрес электронной почты</label>
                <input type="text" class="form-control" id="login" name="login" :class="errors.login ? 'is-invalid' : ''">
                <div class="invalid-feedback" v-for="error in errors.login">
                    @{{ error }}
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Введите пароль</label>
                <input type="password" class="form-control" id="password" name="password" :class="errors.password ? 'is-invalid' : ''">
                <div class="invalid-feedback" v-for="error in errors.password">
                    @{{ error }}
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Авторизоваться</button>
        </form>
    </div>
    <script>
        const app={
            data(){
                return{
                    errors:[],
                    no_user:'',
                }
            },
            methods:{
                async Auth(){
                    let form = document.getElementById('form_auth');
                    let data = new FormData(form);

                    const response = await fetch('{{route('Auth')}}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                        },
                        body:data
                    });
                    if(response.status ===200){
                        window.location = response.url
                    }
                    if(response.status ===400){
                        this.errors = await response.json();
                    }
                    if(response.status ===404){
                        this.no_user = await response.json();
                    }
                }
            }
        }
        Vue.createApp(app).mount('#Auth')
    </script>
@endsection
