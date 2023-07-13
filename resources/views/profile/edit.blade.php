@extends('template')
@section('content')

    <script>
        //отображение всех постов

        let token = document.querySelector('input[name="_token"]').value
        let formData = new FormData();
        formData.append('_token', token);
        fetch('/showMyPosts', {
            method: "post",
            body: formData
        }).then(function (response){ return response.json()})
            .then(function (result){
                console.log(result);
            })

        {{--скрипт вытягивающий информацию из формы если она не пустая и отправляющий ее на сервер--}}
        function addPost(){
            let input = document.getElementById("addPost_input");
            let file = document.getElementById("file_post");

            if(input.value == '' || file.value == ''){
                alert("Вы ничего не написали");
            }else{
                let token = document.querySelector('input[name="_token"]').value
                let formData = new FormData(addPost_form);
                formData.append('_token', token);
                fetch('/addPost', {
                    method: "post",
                    body: formData
                })

            }
        }
        {{--Скрипт для изменеия аватара, в случае если форма не пустая скрипт читает из нее файл и отправляет его на сервер, при получении результата "success" обновляем страницу--}}
        function changeImg(){
            let button = document.getElementById("changeAvatar");
            let img = document.getElementById("img_input");

            if (img.value == ''){
                alert("Вы не выбрали файл");
            }else{
                let token = document.querySelector('input[name="_token"]').value
                let formData = new FormData(img_form)
                formData.append('_token', token);
                fetch('/updateImg', {
                    method: "post",
                    body: formData
                }).then(response=>response.json())
                    .then(result=>{
                        if(result.result === "success"){
                            location.reload();
                        }
                    })

            }
        }
        {{--скрипт для изменения имени и фамилии--}}
        function changeName() {
            let button = document.getElementById("changeName").innerText;
            let name = document.getElementById("userName");

            let lastname = document.getElementById("userLastname");

            if (button === 'Изменить имя и фамилию') {
                document.getElementById("buttonChangeName").innerHTML = '<button id="changeName" onclick="changeName()" class="btn btn-outline-danger" type="button" aria-expanded="false"> сохранить </button>'
                name.removeAttribute("readonly");
                name.classList.remove('form-control-plaintext');
                name.classList.add('form-control');
                lastname.removeAttribute("readonly");
                lastname.classList.remove('form-control-plaintext');
                lastname.classList.add('form-control');
            } else {
                document.getElementById("buttonChangeName").innerHTML = '<button class="btn btn-outline-danger" id="" type="button" data-bs-toggle="dropdown" aria-expanded="false">Изменить профиль </button> <ul class="dropdown-menu"> <li> <button id="changeName" class="dropdown-item" onclick="changeName()">Изменить имя и фамилию</button></li> <li><button class="dropdown-item"  type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Изменить изображение профиля</button></li> <li><button onclick="logout()" class="dropdown-item"  type="button">Выйти</button></li> </ul> <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <h1 class="modal-title fs-5" id="staticBackdropLabel">Изменить аватарку</h1> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button> </div> <div class="modal-body"> <form id="img_form" enctype="multipart/form-data"> <input class="form-control" id="img_input" name="img" type="file"> </div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button> <input type="button" id="changeAvatar" onclick="changeImg()" class="btn btn-primary" data-bs-dismiss="modal" value="Сохранить"></form> </div> </div> </div> </div>'
                name.setAttribute("readonly", "readonly");
                lastname.setAttribute("readonly", "readonly");
                name.classList.remove('form-control');
                name.classList.add('form-control-plaintext');
                lastname.classList.remove('form-control');
                lastname.classList.add('form-control-plaintext');
                let token = document.querySelector('input[name="_token"]').value
                let formData = new FormData()
                formData.append("name", name.value);
                formData.append("lastname", lastname.value);
                formData.append('_token', token);
                fetch('/updateName', {
                    method: "post",
                    body: formData
                });
            }

        }
        {{--скрипт для изменения информаци о себе --}}
        function about(){
            var button =  document.getElementById('change_about');
            var input =  document.getElementById('about');

            if (button.value === 'Изменить') {
                button.value = 'Сохранить';
                input.classList.remove('form-control-plaintext');
                input.classList.add('form-control');
                input.removeAttribute("readonly");
            } else {
                button.value = 'Изменить';
                input.classList.add('form-control-plaintext');
                input.classList.remove('form-control');
                input.classList.add('form-control-plaintext');
                input.setAttribute("readonly", "readonly");
                let token = document.querySelector('input[name="_token"]').value
                let formData = new FormData()
                formData.append("about", input.value);
                formData.append('_token', token);
                fetch('/updateAbout', {
                    method: "post",
                    body: formData
                });
            }
        }
        {{--скрипт для выхода со страницы--}}
        function logout(){
            let token = document.querySelector('input[name="_token"]').value
            let formData = new FormData()
            formData.append('_token', token);
            fetch('/logout', {
                method: "post",
                body: formData
            });
            location.reload();
        }

    </script>
<body>

<!-- =======================
Header START -->
<main>


    <!-- Container START -->
    <div class="container">
        <div class="row g-4">

            <!-- Main content START -->
            <div class="col-lg-8 vstack gap-4">
                <!-- My profile START -->
                <div class="card">
                    <!-- Cover image -->
                    <div class="h-200px rounded-top" style="background-image:url(assets/images/bg/05.jpg); background-position: center; background-size: cover; background-repeat: no-repeat;"></div>
                    <!-- Card body START -->
                    <div class="card-body py-0">
                        <div class="d-sm-flex align-items-start text-center text-sm-start">
                            <div>
                                <!-- Avatar -->

                                <div class="avatar avatar-xxl mt-n5 mb-3">
                                    <img class="avatar-img rounded-circle border border-white border-3" src="{{auth()->user()->img}}" alt="">
                                </div>
                            </div>
                            <div class="ms-sm-4 mt-sm-3">
                                <div class="input-group mb-3 g-1 row">
                                <!-- Info -->
                                    <div class="col-sm-3">
                                <input type="text" aria-label="Имя" class="h5 form-control-plaintext" id="userName" readonly value="{{auth()->user()->name}}">
                                    </div>
                                    <div class="col-sm-4">
                                    <input type="text" aria-label="Фамилия" class="h5 form-control-plaintext" id="userLastname" readonly value="{{auth()->user()->lastname}}">
                                    </div>
                            <!-- Button -->
                            <div class="col-5 ms-auto" id="buttonChangeName">
                                    <button class="btn btn-outline-danger" id="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Изменить профиль
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li> <button id="changeName" class="dropdown-item" onclick="changeName()">Изменить имя и фамилию</button></li>
                                        <li><button class="dropdown-item"  type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Изменить изображение профиля</button></li>
                                        <li><button onclick="logout()" class="dropdown-item"  type="button">Выйти</button></li>
                                    </ul>
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Изменить аватарку</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <form id="img_form" enctype="multipart/form-data">
                                                            <input class="form-control" id="img_input" name="img" type="file">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                                                        <input type="button" id="changeAvatar" onclick="changeImg()" class="btn btn-primary" data-bs-dismiss="modal" value="Сохранить"></form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card body END -->
                </div>
                <!-- My profile END -->
                    @csrf
                <!-- Добавление поста -->
                <div class="card card-body">
                    <div class="d-flex mb-3">
                        <div class="avatar avatar-xs me-2">
                            <a href="#"> <img class="avatar-img rounded-circle" src="{{auth()->user()->img}}" alt=""></a>
                        </div>
                        <form class="w-100">
                            <input class="form-control pe-4 border-0" placeholder="Что у вас нового?" data-bs-toggle="modal" data-bs-target="#modalCreateFeed">
                        </form>
                    </div>
                </div>
                <!-- Добавление поста конец -->

                <!-- Card feed item START -->
                <div class="card">
                    <!-- Card header START -->
                    <div class="card-header border-0 pb-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <!-- Avatar -->
                                <div class="avatar avatar-story me-2">
                                    <a href="#!"> <img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt=""> </a>
                                </div>
                                <!-- Info -->
                                <div>
                                    <div class="nav nav-divider">
                                        <h6 class="nav-item card-title mb-0"> <a href="#!"> Lori Ferguson </a></h6>
                                        <span class="nav-item small"> 2hr</span>
                                    </div>
                                    <p class="mb-0 small">Web Developer at Webestica</p>
                                </div>
                            </div>
                            <!-- Card feed action dropdown START -->
                            <div class="dropdown">
                                <a href="#" class="text-secondary btn btn-secondary-soft-hover py-1 px-2" id="cardFeedAction1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots"></i>
                                </a>
                                <!-- Card feed action dropdown menu -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardFeedAction1">
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-bookmark fa-fw pe-2"></i>Save post</a></li>
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-person-x fa-fw pe-2"></i>Unfollow lori ferguson </a></li>
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-x-circle fa-fw pe-2"></i>Hide post</a></li>
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-slash-circle fa-fw pe-2"></i>Block</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-flag fa-fw pe-2"></i>Report post</a></li>
                                </ul>
                            </div>
                            <!-- Card feed action dropdown END -->
                        </div>
                    </div>

                    <!-- Card header END -->
                    <!-- Card body START -->
                    <div class="card-body">
                        <p>I'm thrilled to share that I've completed a graduate certificate course in project management with the president's honor roll.</p>
                        <!-- Card img -->
                        <img class="card-img" src="assets/images/post/3by2/01.jpg" alt="Post">
                        <!-- Feed react START -->
                        <ul class="nav nav-stack py-3 small">
                            <li class="nav-item">
                                <a class="nav-link active" href="#!"> <i class="bi bi-hand-thumbs-up-fill pe-1"></i>Liked (56)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#!"> <i class="bi bi-chat-fill pe-1"></i>Comments (12)</a>
                            </li>
                            <!-- Card share action START -->
                            <li class="nav-item dropdown ms-sm-auto">
                                <a class="nav-link mb-0" href="#" id="cardShareAction8" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-reply-fill flip-horizontal ps-1"></i>Share (3)
                                </a>
                                <!-- Card share action dropdown menu -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction8">
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-envelope fa-fw pe-2"></i>Send via Direct Message</a></li>
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-bookmark-check fa-fw pe-2"></i>Bookmark </a></li>
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-link fa-fw pe-2"></i>Copy link to post</a></li>
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-share fa-fw pe-2"></i>Share post via …</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-pencil-square fa-fw pe-2"></i>Share to News Feed</a></li>
                                </ul>
                            </li>
                            <!-- Card share action END -->
                        </ul>
                        <!-- Feed react END -->

                        <!-- Add comment -->
                        <div class="d-flex mb-3">
                            <!-- Avatar -->
                            <div class="avatar avatar-xs me-2">
                                <a href="#!"> <img class="avatar-img rounded-circle" src="assets/images/avatar/12.jpg" alt=""> </a>
                            </div>
                            <!-- Comment box  -->
                            <form class="position-relative w-100">
                                <textarea class="form-control pe-4 bg-light" rows="1" placeholder="Add a comment..."></textarea>
                            </form>
                        </div>
                        <!-- Comment wrap START -->
                        <ul class="comment-wrap list-unstyled">
                            <!-- Comment item START -->
                            <li class="comment-item">
                                <div class="d-flex position-relative">
                                    <!-- Avatar -->
                                    <div class="avatar avatar-xs">
                                        <a href="#!"><img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt=""></a>
                                    </div>
                                    <div class="ms-2">
                                        <!-- Comment by -->
                                        <div class="bg-light rounded-start-top-0 p-3 rounded">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1"> <a href="#!"> Frances Guerrero </a></h6>
                                                <small class="ms-2">5hr</small>
                                            </div>
                                            <p class="small mb-0">Removed demands expense account in outward tedious do. Particular way thoroughly unaffected projection.</p>
                                        </div>
                                        <!-- Comment react -->
                                        <ul class="nav nav-divider py-2 small">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!"> Like (3)</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!"> Reply</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!"> View 5 replies</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Comment item nested START -->
                                <ul class="comment-item-nested list-unstyled">
                                    <!-- Comment item START -->
                                    <li class="comment-item">
                                        <div class="d-flex">
                                            <!-- Avatar -->
                                            <div class="avatar avatar-xs">
                                                <a href="#!"><img class="avatar-img rounded-circle" src="assets/images/avatar/06.jpg" alt=""></a>
                                            </div>
                                            <!-- Comment by -->
                                            <div class="ms-2">
                                                <div class="bg-light p-3 rounded">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="mb-1"> <a href="#!"> Lori Stevens </a> </h6>
                                                        <small class="ms-2">2hr</small>
                                                    </div>
                                                    <p class="small mb-0">See resolved goodness felicity shy civility domestic had but Drawings offended yet answered Jennings perceive.</p>
                                                </div>
                                                <!-- Comment react -->
                                                <ul class="nav nav-divider py-2 small">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#!"> Like (5)</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#!"> Reply</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Comment item END -->
                                    <!-- Comment item START -->
                                    <li class="comment-item">
                                        <div class="d-flex">
                                            <!-- Avatar -->
                                            <div class="avatar avatar-story avatar-xs">
                                                <a href="#!"><img class="avatar-img rounded-circle" src="assets/images/avatar/07.jpg" alt=""></a>
                                            </div>
                                            <!-- Comment by -->
                                            <div class="ms-2">
                                                <div class="bg-light p-3 rounded">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="mb-1"> <a href="#!"> Billy Vasquez </a> </h6>
                                                        <small class="ms-2">15min</small>
                                                    </div>
                                                    <p class="small mb-0">Wishing calling is warrant settled was lucky.</p>
                                                </div>
                                                <!-- Comment react -->
                                                <ul class="nav nav-divider py-2 small">
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#!"> Like</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="#!"> Reply</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- Comment item END -->
                                </ul>
                                <!-- Load more replies -->
                                <a href="#!" role="button" class="btn btn-link btn-link-loader btn-sm text-secondary d-flex align-items-center mb-3 ms-5" data-bs-toggle="button" aria-pressed="true">
                                    <div class="spinner-dots me-2">
                                        <span class="spinner-dot"></span>
                                        <span class="spinner-dot"></span>
                                        <span class="spinner-dot"></span>
                                    </div>
                                    Load more replies
                                </a>
                                <!-- Comment item nested END -->
                            </li>
                            <!-- Comment item END -->
                            <!-- Comment item START -->
                            <li class="comment-item">
                                <div class="d-flex">
                                    <!-- Avatar -->
                                    <div class="avatar avatar-xs">
                                        <a href="#!"><img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt=""></a>
                                    </div>
                                    <!-- Comment by -->
                                    <div class="ms-2">
                                        <div class="bg-light p-3 rounded">
                                            <div class="d-flex justify-content-between">
                                                <h6 class="mb-1"> <a href="#!"> Frances Guerrero </a> </h6>
                                                <small class="ms-2">4min</small>
                                            </div>
                                            <p class="small mb-0">Removed demands expense account in outward tedious do. Particular way thoroughly unaffected projection.</p>
                                        </div>
                                        <!-- Comment react -->
                                        <ul class="nav nav-divider pt-2 small">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!"> Like (1)</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!"> Reply</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#!"> View 6 replies</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <!-- Comment item END -->
                        </ul>
                        <!-- Comment wrap END -->
                    </div>
                    <!-- Card body END -->
                    <!-- Card footer START -->
                    <div class="card-footer border-0 pt-0">
                        <!-- Load more comments -->
                        <a href="#!" role="button" class="btn btn-link btn-link-loader btn-sm text-secondary d-flex align-items-center" data-bs-toggle="button" aria-pressed="true">
                            <div class="spinner-dots me-2">
                                <span class="spinner-dot"></span>
                                <span class="spinner-dot"></span>
                                <span class="spinner-dot"></span>
                            </div>
                            Load more comments
                        </a>
                    </div>
                    <!-- Card footer END -->
                </div>
                <!-- Card feed item END -->

                <!-- Card feed item START -->
                <div class="card">
                    <!-- Card header START -->

                    <!-- Card body START -->
                    <!-- Card body END -->
                    <!-- Card Footer START -->
                    <div class="card-footer py-3">
                        <!-- Feed react START -->
                        <ul class="nav nav-fill nav-stack small">
                            <li class="nav-item">
                                <a class="nav-link mb-0 active" href="#!"> <i class="bi bi-heart pe-1"></i>Liked (56)</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0" href="#!"> <i class="bi bi-chat-fill pe-1"></i>Comments (12)</a>
                            </li>
                            <!-- Card share action dropdown START -->
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link mb-0" id="cardShareAction6" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-reply-fill flip-horizontal ps-1"></i>Share (3)
                                </a>
                                <!-- Card share action dropdown menu -->
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cardShareAction6">
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-envelope fa-fw pe-2"></i>Send via Direct Message</a></li>
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-bookmark-check fa-fw pe-2"></i>Bookmark </a></li>
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-link fa-fw pe-2"></i>Copy link to post</a></li>
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-share fa-fw pe-2"></i>Share post via …</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#"> <i class="bi bi-pencil-square fa-fw pe-2"></i>Share to News Feed</a></li>
                                </ul>
                            </li>
                            <!-- Card share action dropdown END -->
                            <li class="nav-item">
                                <a class="nav-link mb-0" href="#!"> <i class="bi bi-send-fill pe-1"></i>Send</a>
                            </li>
                        </ul>
                        <!-- Feed react END -->
                    </div>
                    <!-- Card Footer END -->
                </div>
                <!-- Card feed item END -->
            </div>
            <!-- Main content END -->

            <!-- Right sidebar START -->
            <div class="col-lg-4">

                <div class="row g-4">

                    <!-- Card START -->
                    <div class="col-md-6 col-lg-12">
                        <div class="card">
                            <div class="card-header border-0 pb-0">
                                <h5 class="card-title">О себе</h5>
                                <!-- Button modal -->
                            </div>
                            <!-- Card body START -->
                            <div class="card-body position-relative pt-0">
                                <input type="text" id="about"  class="form-control-plaintext" readonly value="{{auth()->user()->about}}">
                                <input id="change_about" onclick="about()" class="btn btn-primary-soft btn-sm col-sm-4" type="button" value="Изменить">
                                <!-- Date time -->
                                <ul class="list-unstyled mt-3 mb-0">
                                    <li class="mb-2"> <i class="bi bi-calendar-date fa-fw pe-1"></i> Дата рождения: <strong> {{auth()->user()->birthday}} </strong> </li>
                                    <li> <i class="bi bi-envelope fa-fw pe-1"></i> Email: <strong> {{auth()->user()->email}} </strong> </li>
                                </ul>
                            </div>
                            <!-- Card body END -->
                        </div>
                    </div>
                    <!-- Card END -->

                    <!-- Card START -->
                    <div class="col-md-6 col-lg-12">
                        <div class="card">
                    <!-- Card START -->
                    <div class="col-md-6 col-lg-12">
                    </div>
                        </div>
                    </div>
                    <!-- Card END -->

                    <!-- Card START -->
                    <div class="col-md-6 col-lg-12">
                        <div class="card">
                            <!-- Card header START -->
                            <div class="card-header d-sm-flex justify-content-between align-items-center border-0">
                                <h5 class="card-title">Друзья <span class="badge bg-danger bg-opacity-10 text-danger">{{auth()->user()->friends_count}}</span></h5>
                                <a class="btn btn-primary-soft btn-sm" href="/friends"> Показать всех друзей</a>
                            </div>
                            <!-- Card header END -->
                            <!-- Card body START -->
                            <div class="card-body position-relative pt-0">
                                <div class="row g-3">

                                    <div class="col-6">
                                        <!-- Friends item START -->
                                        <div class="card shadow-none text-center h-100">
                                            <!-- Card body -->
                                            <div class="card-body p-2 pb-0">
                                                <div class="avatar avatar-story avatar-xl">
                                                    <a href="#!"><img class="avatar-img rounded-circle" src="assets/images/avatar/02.jpg" alt=""></a>
                                                </div>
                                                <h6 class="card-title mb-1 mt-3"> <a href="#!"> Amanda Reed </a></h6>
                                                <p class="mb-0 small lh-sm">16 mutual connections</p>
                                            </div>
                                            <!-- Card footer -->
                                            <div class="card-footer p-2 border-0">
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Send message"> <i class="bi bi-chat-left-text"></i> </button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove friend"> <i class="bi bi-person-x"></i> </button>
                                            </div>
                                        </div>
                                        <!-- Friends item END -->
                                    </div>

                                    <div class="col-6">
                                        <!-- Friends item START -->
                                        <div class="card shadow-none text-center h-100">
                                            <!-- Card body -->
                                            <div class="card-body p-2 pb-0">
                                                <div class="avatar avatar-xl">
                                                    <a href="#!"><img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt=""></a>
                                                </div>
                                                <h6 class="card-title mb-1 mt-3"> <a href="#!"> Samuel Bishop </a></h6>
                                                <p class="mb-0 small lh-sm">22 mutual connections</p>
                                            </div>
                                            <!-- Card footer -->
                                            <div class="card-footer p-2 border-0">
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Send message"> <i class="bi bi-chat-left-text"></i> </button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove friend"> <i class="bi bi-person-x"></i> </button>
                                            </div>
                                        </div>
                                        <!-- Friends item END -->
                                    </div>

                                    <div class="col-6">
                                        <!-- Friends item START -->
                                        <div class="card shadow-none text-center h-100">
                                            <!-- Card body -->
                                            <div class="card-body p-2 pb-0">
                                                <div class="avatar avatar-xl">
                                                    <a href="#!"><img class="avatar-img rounded-circle" src="assets/images/avatar/04.jpg" alt=""></a>
                                                </div>
                                                <h6 class="card-title mb-1 mt-3"> <a href="#"> Bryan Knight </a></h6>
                                                <p class="mb-0 small lh-sm">1 mutual connection</p>
                                            </div>
                                            <!-- Card footer -->
                                            <div class="card-footer p-2 border-0">
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Send message"> <i class="bi bi-chat-left-text"></i> </button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove friend"> <i class="bi bi-person-x"></i> </button>
                                            </div>
                                        </div>
                                        <!-- Friends item END -->
                                    </div>

                                    <div class="col-6">
                                        <!-- Friends item START -->
                                        <div class="card shadow-none text-center h-100">
                                            <!-- Card body -->
                                            <div class="card-body p-2 pb-0">
                                                <div class="avatar avatar-xl">
                                                    <a href="#!"><img class="avatar-img rounded-circle" src="assets/images/avatar/05.jpg" alt=""></a>
                                                </div>
                                                <h6 class="card-title mb-1 mt-3"> <a href="#!"> Amanda Reed </a></h6>
                                                <p class="mb-0 small lh-sm">15 mutual connections</p>
                                            </div>
                                            <!-- Card footer -->
                                            <div class="card-footer p-2 border-0">
                                                <button class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Send message"> <i class="bi bi-chat-left-text"></i> </button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove friend"> <i class="bi bi-person-x"></i> </button>
                                            </div>
                                        </div>
                                        <!-- Friends item END -->
                                    </div>

                                </div>
                            </div>
                            <!-- Card body END -->
                        </div>
                    </div>
                    <!-- Card END -->
                </div>

            </div>
            <!-- Right sidebar END -->

        </div> <!-- Row END -->
    </div>
    <!-- Container END -->

</main>
<!-- **************** MAIN CONTENT END **************** -->

{{--<!-- Modal create Feed photo START -->
<div class="modal fade" id="modalCreateFeed" tabindex="-1" aria-labelledby="modalLabelCreateFeed" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelCreateFeed">Добавить запись</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex mb-3">
                    <div class="avatar avatar-xs me-2">
                        <img class="avatar-img rounded-circle" src="{{auth()->user()->img}}" alt="">
                    </div>
                    <form id="addPost_form" enctype="multipart/form-data" class="w-100" novalidate>
                        <div class="">
                        <textarea name="post_content" id="addPost_input" class="form-control pe-4 fs-3 lh-1 border-0" rows="4" placeholder="Что у вас нового?" autofocus></textarea>
                         --}}{{--<input id="img_post" name="img_post" type="file">
                        <input id="video_post" name="video_post" type="file">--}}{{--
                        </div>
                        <div class="dropzone addPost_dropzone" id="dropzone">
                            <div class="">
                                <div class="dz-message">
                                    <i class="bi bi-images display-3"></i>
                                    <p>Выберите файл или перетащите его сюда</p>
                                </div>
                            </div>
                        </div>
                        <input type="submit" id="addPost_button" onclick="addPost()" aria-label="Close" data-bs-dismiss="modal" class="btn btn-success-soft" value="Опубликовать">
                    </form>
                </div>
                <script>
                    var dropzone = new Dropzone("#dropzone", {
                        createImageThumbnails: false,
                        addRemoveLinks: true,
                        url: "(/addPost)"
                    });
                </script>
            </div>
            <!-- Modal feed body END -->
            <div class="modal-footer row justify-content-between">
                <form>
                    <div class="col-lg-8 align-self-end">
                        <label type="button" onclick="addPost()" class="btn btn-success-soft" for="addPost_button">Опубликовать</label>
                    </div>
                </form>
        </div>
    </div>
</div>--}}
<!-- Modal create Feed photo END -->

    <!-- Добавление поста окно -->
    <div class="modal fade" id="modalCreateFeed" tabindex="-1" aria-labelledby="modalLabelCreateFeed" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabelCreateFeed">Добавить запись</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex mb-3">
                        <div class="avatar avatar-xs me-2">
                            <img class="avatar-img rounded-circle" src="{{auth()->user()->img}}" alt="">
                        </div>
                        <form id="addPost_form" enctype="multipart/form-data" class="w-100 " novalidate>
                            <textarea name="post_content" id="addPost_input" class="form-control pe-4 fs-3 lh-1 border-0" rows="4" placeholder="Что у вас нового?" autofocus></textarea>
                            <input id="file_post" name="file[]" type="file" multiple>
                            <input type="button" id="addPost_button" onclick="addPost()" aria-label="Close" data-bs-dismiss="modal" class="btn btn-success-soft" value="Опубликовать">
                        </form>
                    </div>
                    <div class="hstack gap-2">
                        <label for="file_post" class="btn icon-md bg-success bg-opacity-10 text-success rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Photo" >
                            <i class="bi bi-image-fill"></i>
                        </label>
                        <label for="file_post" class="btn icon-md bg-info bg-opacity-10 text-info rounded-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Video" >
                            <i class="bi bi-camera-reels-fill"></i>
                        </label>
                    </div>

                </div>

                <div class="modal-footer row justify-content-between">
                        <div class="col-lg-8 align-self-end">
                        <label for="addPost_button" aria-label="Close" data-bs-dismiss="modal" class="btn btn-success-soft">Опубликовать</label>
                    </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Добавление конца окно конец -->


{{--<!-- Modal create Feed photo START -->
<div class="modal fade" id="feedActionPhoto" tabindex="-1" aria-labelledby="feedActionPhotoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal feed header START -->
            <div class="modal-header">
                <h5 class="modal-title" id="feedActionPhotoLabel">Добавить запись</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal feed header END -->

            <!-- Modal feed body START -->
            <div class="modal-body">
                <!-- Add Feed -->
                <div class="d-flex mb-3">
                    <!-- Avatar -->
                    <div class="avatar avatar-xs me-2">
                        <img class="avatar-img rounded-circle" src="{{auth()->user()->img}}" alt="">
                    </div>
                    <!-- Feed box  -->
                    <form class="w-100">
                        <textarea class="form-control pe-4 fs-3 lh-1 border-0" rows="2" placeholder="Что у вас нового?"></textarea>
                    </form>
                </div>

                <!-- Dropzone photo START -->
                <div>
                    <div class="dropzone dropzone-default card shadow-none" data-dropzone='{"maxFiles":10}'>
                        <div class="dz-message">
                            <i class="bi bi-images display-3"></i>
                            <p>Выберите файл или перетащите его сюда</p>
                        </div>
                    </div>
                </div>
                <!-- Dropzone photo END -->

            </div>
            <!-- Modal feed body END -->

            <!-- Modal feed footer -->
            <div class="modal-footer">
                <!-- Button -->
                <button type="button" class="btn btn-success-soft ml-0">Опубликовать</button>
            </div>
            <!-- Modal feed footer -->
        </div>
    </div>
</div>
<!-- Modal create Feed photo END -->

<!-- Modal create Feed video START -->
<div class="modal fade" id="feedActionVideo" tabindex="-1" aria-labelledby="feedActionVideoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal feed header START -->
            <div class="modal-header">
                <h5 class="modal-title" id="feedActionVideoLabel">Add post video</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal feed header END -->

            <!-- Modal feed body START -->
            <div class="modal-body">
                <!-- Add Feed -->
                <div class="d-flex mb-3">
                    <!-- Avatar -->
                    <div class="avatar avatar-xs me-2">
                        <img class="avatar-img rounded-circle" src="assets/images/avatar/03.jpg" alt="">
                    </div>
                    <!-- Feed box  -->
                    <form class="w-100">
                        <textarea class="form-control pe-4 fs-3 lh-1 border-0" rows="2" placeholder="Share your thoughts..."></textarea>
                    </form>
                </div>

                <!-- Dropzone photo START -->
                <div>
                    <label class="form-label">Upload attachment</label>
                    <div class="dropzone dropzone-default card shadow-none" data-dropzone='{"maxFiles":2}'>
                        <div class="dz-message">
                            <i class="bi bi-camera-reels display-3"></i>
                            <p>Drag here or click to upload video.</p>
                        </div>
                    </div>
                </div>
                <!-- Dropzone photo END -->

            </div>
            <!-- Modal feed body END -->

            <!-- Modal feed footer -->
            <div class="modal-footer">
                <!-- Button -->
                <button type="button" class="btn btn-danger-soft me-2"><i class="bi bi-camera-video-fill pe-1"></i> Live video</button>
                <button type="button" class="btn btn-success-soft">Post</button>
            </div>
            <!-- Modal feed footer -->
        </div>
    </div>
</div>
<!-- Modal create Feed video END -->--}}

<!-- Modal create events START -->
{{--<div class="modal fade" id="modalCreateEvents" tabindex="-1" aria-labelledby="modalLabelCreateAlbum" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal feed header START -->
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabelCreateAlbum">Create event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal feed header END -->
            <!-- Modal feed body START -->
            <div class="modal-body">
                <!-- Form START -->
                <!-- Form END -->
            </div>
            <!-- Modal feed body END -->
            <!-- Modal footer -->
            <!-- Button -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger-soft me-2" data-bs-dismiss="modal"> Cancel</button>
                <button type="button" class="btn btn-success-soft">Create now</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal create events END -->--}}

<!-- =======================
JS libraries, plugins and custom scripts -->

<!-- Bootstrap JS -->
<script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

<!-- Vendors -->
<script src="assets/vendor/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="assets/vendor/glightbox-master/dist/js/glightbox.min.js"></script>
<script src="assets/vendor/flatpickr/dist/flatpickr.min.js"></script>

<!-- Theme Functions -->
<script src="assets/js/functions.js"></script>

</body>
@endsection
