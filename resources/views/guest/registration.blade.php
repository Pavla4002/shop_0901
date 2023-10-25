@extends('layout.app')
@section('title')
   Регистрация
@endsection
@section('main')
    <div class="container-fluid w-75" id="app">
        <div>
            <h1>
                Регистрация
            </h1>
        </div>
        <div>
            <div :class="message ? 'alert alert-success':''">
                @{{ message }}
            </div>
            <form id="form_reg" @submit.prevent="Registration">
                <div class="mb-3">
                    <label for="fio" class="form-label">Введите ФИО</label>
                    <input type="text" class="form-control" id="fio" aria-describedby="emailHelp" name="fio" :class="errors.fio ? 'is-invalid' : ''">
                    <div class="invalid-feedback" v-for="error in errors.email">
                        @{{ error }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label">Введите дату рождения</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" :class="errors.birthday ? 'is-invalid' : ''">
                    <div class="invalid-feedback" v-for="error in errors.birthday">
                        @{{ error }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Введите адрес электронной почты</label>
                    <input type="email" class="form-control" id="email" name="email" :class="errors.email ? 'is-invalid' : ''">
                    <div class="invalid-feedback" v-for="error in errors.email">
                        @{{ error }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Введите номер телефона</label>
                    <input type="tel" class="form-control" id="phone" name="phone" :class="errors.phone ? 'is-invalid' : ''">
                    <div class="invalid-feedback" v-for="error in errors.phone">
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
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Повторите пароль</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" :class="errors.password ? 'is-invalid' : ''">
                    <div class="invalid-feedback" v-for="error in errors.password">
                        @{{ error }}
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Зарегаться</button>
            </form>
        </div>
    </div>


    <script>
        const app={
            data(){
                return{
                    errors:[],
                    message:'',
                }
            },
            methods:{
                async Registration(){
                    let form = document.getElementById('form_reg')
                    let form_data = new FormData(form)
                    const response = await fetch('{{route('Registration')}}',{
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN': '{{csrf_token()}}',
                            'Accept':'application/json'
                        },
                        body:form_data,
                    });
                    if(response.status===422){
                        this.errors = (await response.json()).errors;
                        setTimeout(()=>{
                            this.errors = [];
                        },5000)
                    }
                    if(response.status===200){
                        this.message = await response.json();
                        setTimeout(()=>{
                            this.message = '';
                        },10000)
                    }
                }
            }
        }
        Vue.createApp(app).mount('#app')
    </script>
@endsection
