<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- MESSAGE CHAT -->
    <!-- MESSAGE CHAT BOX CDNS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- GOOGLE FONTS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Aaron Burks  </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/feather/feather.css">
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="vendors/typicons/typicons.css">
  <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" href="js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/sitelogo-singup.png" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.php -->
    <?php 
     include 'header.php'
    ?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      
      <div id="right-sidebar" class="settings-panel">
        <i class="settings-close ti-close"></i>
        <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab"n" aria-expanded="true">TO DO LIST</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab"n">CHATS</a>
          </li>
        </ul>
        <div class="tab-content" id="setting-content">
          <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
            <div class="add-items d-flex px-3 mb-0">
              <form class="form w-100">
                <div class="form-group d-flex">
                  <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                  <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                </div>
              </form>
            </div>
            <div class="list-wrapper px-3">
              <ul class="d-flex flex-column-reverse todo-list">
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Team review meeting at 3.00 PM
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Prepare for presentation
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li>
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox">
                      Resolve all the low priority tickets due today
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li class="completed">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Schedule meeting for next week
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
                <li class="completed">
                  <div class="form-check">
                    <label class="form-check-label">
                      <input class="checkbox" type="checkbox" checked>
                      Project review
                    </label>
                  </div>
                  <i class="remove ti-close"></i>
                </li>
              </ul>
            </div>
            <h4 class="px-3 text-muted mt-5 fw-light mb-0">Events</h4>
            <div class="events pt-4 px-3">
              <div class="wrapper d-flex mb-2">
                <i class="ti-control-record text-primary me-2"></i>
                <span>Feb 11 2018</span>
              </div>
              <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
              <p class="text-gray mb-0">The total number of sessions</p>
            </div>
            <div class="events pt-4 px-3">
              <div class="wrapper d-flex mb-2">
                <i class="ti-control-record text-primary me-2"></i>
                <span>Feb 7 2018</span>
              </div>
              <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
              <p class="text-gray mb-0 ">Call Sarah Graves</p>
            </div>
          </div>
          <!-- To do section tab ends -->
          <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
            <div class="d-flex align-items-center justify-content-between border-bottom">
              <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
              <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 fw-normal">See All</small>
            </div>
            <ul class="chat-list">
              <li class="list active">
                <div class="profile"><img src="images/faces/face1.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Thomas Douglas</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">19 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face2.jpg" alt="image"><span class="offline"></span></div>
                <div class="info">
                  <div class="wrapper d-flex">
                    <p>Catherine</p>
                  </div>
                  <p>Away</p>
                </div>
                <div class="badge badge-success badge-pill my-auto mx-2">4</div>
                <small class="text-muted my-auto">23 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face3.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Daniel Russell</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">14 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face4.jpg" alt="image"><span class="offline"></span></div>
                <div class="info">
                  <p>James Richardson</p>
                  <p>Away</p>
                </div>
                <small class="text-muted my-auto">2 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face5.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Madeline Kennedy</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">5 min</small>
              </li>
              <li class="list">
                <div class="profile"><img src="images/faces/face6.jpg" alt="image"><span class="online"></span></div>
                <div class="info">
                  <p>Sarah Graves</p>
                  <p>Available</p>
                </div>
                <small class="text-muted my-auto">47 min</small>
              </li>
            </ul>
          </div>
          <!-- chat tab ends -->
        </div>
      </div>
      <!-- partial -->
      <!-- partial:partials/_sidebar.php -->
      <?php
      include 'SideMenu.php'
      ?>
      <!-- partial -->
      <div class="main-panel">
        <!-- START ROW MAIN-PANEL -->
        <!-- MESSAGE BOX START  -->
      <!-- char-area -->
<section class="message-area">
    <div class="container">
        <h2 style="color: #000; font-weight: bold;">Messages</h2>
        <p style="color: #70BE44; padding-bottom: 20px;">Here are your Service Providers Chats </p>
      <div class="row">
        <div class="col-12">
          <div class="chat-area">
            <!-- chatlist -->
            <div class="chatlist">
              <div class="modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="chat-header">
                    <div class="msg-search">
                      <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search" aria-label="search">
                      <a class="add" href="#"><img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/add.svg" alt="add"></a>
                    </div>
  
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="Open-tab" data-bs-toggle="tab" data-bs-target="#Open" type="button" role="tab"" aria-selected="true">Open</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Closed-tab" data-bs-toggle="tab" data-bs-target="#Closed" type="button" role="tab"" aria-selected="false">Closed</button>
                      </li>
                    </ul>
                  </div>
  
                  <div class="modal-body">
                    <!-- chat-list -->
                    <div class="chat-lists">
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="Open" role="tabpanel" aria-labelledby="Open-tab">
                          <!-- chat-list -->
                          <div class="chat-list">
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                <span class="active"></span>
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Mehedi Hasan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Ryhan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Malek Hasan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Sadik Hasan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Bulu </h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Maria SK</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Dipa Hasan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Jhon Hasan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Tumpa Moni</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Payel Akter</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Baby Akter</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Zuwel Rana</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Habib </h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Jalal Ahmed</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Hasan Ali</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Mehedi Hasan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
  
                          </div>
                          <!-- chat-list -->
                        </div>
                        <div class="tab-pane fade" id="Closed" role="tabpanel" aria-labelledby="Closed-tab">
  
                          <!-- chat-list -->
                          <div class="chat-list">
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                <span class="active"></span>
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Mehedi Hasan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Ryhan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Malek Hasan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Sadik Hasan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Bulu </h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Maria SK</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Dipa Hasan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Jhon Hasan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Tumpa Moni</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Payel Akter</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Baby Akter</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Zuwel Rana</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Habib </h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Jalal Ahmed</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Hasan Ali</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
                            <a href="#" class="d-flex align-items-center">
                              <div class="flex-shrink-0">
                                <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                              </div>
                              <div class="flex-grow-1 ms-3">
                                <h3>Mehedi Hasan</h3>
                                <p>front end developer</p>
                              </div>
                            </a>
  
                          </div>
                          <!-- chat-list -->
                        </div>
                      </div>
  
                    </div>
                    <!-- chat-list -->
                  </div>
                </div>
              </div>
            </div>
            <!-- chatlist -->
  
            <!-- chatbox -->
            <div class="chatbox showbox">
              <div class="modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="msg-head">
                    <div class="row">
                      <div class="col-8">
                        <div class="d-flex align-items-center">
                          <span class="chat-icon"><img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/arroleftt.svg" alt="image title"></span>
                          <div class="flex-shrink-0">
                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                          </div>
                          <div class="flex-grow-1 ms-3">
                            <h3>Mehedi Hasan</h3>
                            <p>front end developer</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <ul class="moreoption">
                          <li class="navbar nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></a>
                            <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="#">Action</a></li>
                              <li><a class="dropdown-item" href="#">Another action</a></li>
                              <li>
                                <hr class="dropdown-divider">
                              </li>
                              <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
  
                  <div class="modal-body">
                    <div class="msg-body">
                      <ul>
                        <li class="sender">
                          <p> Hey, Are you there? </p>
                          <span class="time">10:06 am</span>
                        </li>
                        <li class="sender">
                          <p> Hey, Are you there? </p>
                          <span class="time">10:16 am</span>
                        </li>
                        <li class="repaly">
                          <p>yes!</p>
                          <span class="time">10:20 am</span>
                        </li>
                        <li class="sender">
                          <p> Hey, Are you there? </p>
                          <span class="time">10:26 am</span>
                        </li>
                        <li class="sender">
                          <p> Hey, Are you there? </p>
                          <span class="time">10:32 am</span>
                        </li>
                        <li class="repaly">
                          <p>How are you?</p>
                          <span class="time">10:35 am</span>
                        </li>
                        <li>
                          <div class="divider">
                            <h6>Today</h6>
                          </div>
                        </li>
  
                        <li class="repaly">
                          <p> yes, tell me</p>
                          <span class="time">10:36 am</span>
                        </li>
                        <li class="repaly">
                          <p>yes... on it</p>
                          <span class="time">junt now</span>
                        </li>
  
                      </ul>
                    </div>
                  </div>
  
                  <div class="send-box">
                    <form action="">
                      <input type="text" class="form-control" aria-label="message…" placeholder="Write message…">
  
                      <button type="button"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
                    </form>
  
                    <div class="send-btns">
                      <div class="attach">
                        <div class="button-wrapper">
                          <span class="label">
                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/upload.svg" alt="image title"> attached file
                          </span><input type="file" name="upload" id="upload" class="upload-box" placeholder="Upload File" aria-label="Upload File">
                        </div>
  
                        <select class="form-control" id="exampleFormControlSelect1">
                          <option>Select template</option>
                          <option>Template 1</option>
                          <option>Template 2</option>
                        </select>
  
                        <div class="add-apoint">
                          <a href="#" data-toggle="modal" data-target="#exampleModal4"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewbox="0 0 16 16" fill="none">
                              <path d="M8 16C3.58862 16 0 12.4114 0 8C0 3.58862 3.58862 0 8 0C12.4114 0 16 3.58862 16 8C16 12.4114 12.4114 16 8 16ZM8 1C4.14001 1 1 4.14001 1 8C1 11.86 4.14001 15 8 15C11.86 15 15 11.86 15 8C15 4.14001 11.86 1 8 1Z" fill="#7D7D7D" />
                              <path d="M11.5 8.5H4.5C4.224 8.5 4 8.276 4 8C4 7.724 4.224 7.5 4.5 7.5H11.5C11.776 7.5 12 7.724 12 8C12 8.276 11.776 8.5 11.5 8.5Z" fill="#7D7D7D" />
                              <path d="M8 12C7.724 12 7.5 11.776 7.5 11.5V4.5C7.5 4.224 7.724 4 8 4C8.276 4 8.5 4.224 8.5 4.5V11.5C8.5 11.776 8.276 12 8 12Z" fill="#7D7D7D" />
                            </svg> Appoinment</a>
                        </div>
                      </div>
                    </div>
  
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- chatbox -->
  
        </div>
      </div>
    </div>
    </div>
  </section>
  <!-- char-area -->
      <!-- MESSAGE BOX END -->
        <!-- END ROW MAIN PANEL -->
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="vendors/progressbar.js/progressbar.min.js"></script>

  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/jquery.cookie.js" type="text/javascript"></script>
  <script src="js/dashboard.js"></script>
  <script src="js/Chart.roundedBarCharts.js"></script>
  <script src="script.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <!-- End custom js for this page-->
</body>

</html>
<style>



    /* HTML5 display-role reset for older browsers */
    
    article,
    aside,
    details,
    figcaption,
    figure,
    footer,
    header,
    hgroup,
    menu,
    nav,
    section {
        display: block;
    }
    
    body {
        line-height: 1.5;
    }
    
    ol,
    ul {
        list-style: none;
    }
    
    blockquote,
    q {
        quotes: none;
    }
    
    blockquote:before,
    blockquote:after,
    q:before,
    q:after {
        content: '';
        content: none;
    }
    
    table {
        border-collapse: collapse;
        border-spacing: 0;
    }
    
    
    /********************************
     Typography Style
    ******************************** */
    
    body {
        margin: 0;
        font-family: 'Open Sans', sans-serif;
        line-height: 1.5;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    html {
        min-height: 100%;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    
    h1 {
        font-size: 36px;
    }
    
    h2 {
        font-size: 30px;
    }
    
    h3 {
        font-size: 26px;
    }
    
    h4 {
        font-size: 22px;
    }
    
    h5 {
        font-size: 18px;
    }
    
    h6 {
        font-size: 16px;
    }
    
    p {
        font-size: 15px;
    }
    
    a {
        text-decoration: none;
        font-size: 15px;
    }
    
    * {
      margin-bottom: 0;
    }
    
    
    /* *******************************
    message-area
    ******************************** */
    
    .message-area {
        height: 100vh;
        overflow: hidden;
        padding: 30px 0;
    }
    
    .chat-area {
        position: relative;
        width: 100%;
        background-color: #fff;
        border-radius: 0.3rem;
        height: 84vh;
        overflow: hidden;
        min-height: calc(100% - 1rem);
        border: 2px solid #72b763;
    }
    
    .chatlist {
        outline: 0;
        height: 100%;
        overflow: hidden;
        width: 300px;
        float: left;
        padding: 15px;
    }
    
    .chat-area .modal-content {
        border: none;
        border-radius: 0;
        outline: 0;
        height: 100%;
    }
    ::-webkit-scrollbar {
    width: 5px;
}
::-webkit-scrollbar-thumb {
    border-radius: 10px;
}
::-webkit-scrollbar-thumb {
    background: #72b763!important;
}
::selection {
    background: #70BE44;
    color: #fff;
}
#Closed {
    opacity: 1;
}
.modal-content {
    background: #fff;
    box-shadow: unset;
    padding: 0 0;
}
    .chat-area .modal-dialog-scrollable {
        height: 100% !important;
    }
    
    .chatbox {
        width: auto;
        overflow: hidden;
        height: 100%;
        border-left: 1px solid #ccc;
    }
    
    .chatbox .modal-dialog,
    .chatlist .modal-dialog {
        max-width: 100%;
        margin: 0;
    }
    
    .msg-search {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .chat-area .form-control {
        display: block;
        width: 80%;
        padding: 2.375rem 0.75rem;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.5;
        color: #222;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ccc;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
    
    .chat-area .form-control:focus {
        outline: 0;
        box-shadow: inherit;
    }
    
    a.add img {
        height: 36px;
    }
    
    .chat-area .nav-tabs {
        border-bottom: 1px solid #dee2e6;
        align-items: center;
        justify-content: space-between;
        flex-wrap: inherit;
    }
    
    .chat-area .nav-tabs .nav-item {
        width: 100%;
    }
    
    .chat-area .nav-tabs .nav-link {
        width: 100%;
        color: #180660;
        font-size: 14px;
        font-weight: 500;
        line-height: 1.5;
        text-transform: capitalize;
        margin-top: 5px;
        margin-bottom: -1px;
        background: 0 0;
        border: 1px solid transparent;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }
    
    .chat-area .nav-tabs .nav-item.show .nav-link,
    .chat-area .nav-tabs .nav-link.active {
        color: #222;
        background-color: #fff;
        border-color: transparent transparent #000;
    }
    
    .chat-area .nav-tabs .nav-link:focus,
    .chat-area .nav-tabs .nav-link:hover {
        border-color: transparent transparent #000;
        isolation: isolate;
    }
    
    .chat-list h3 {
        color: #222;
        font-size: 16px;
        font-weight: 500;
        line-height: 1.5;
        text-transform: capitalize;
        margin-bottom: 0;
    }
    
    .chat-list p {
        color: #343434;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.5;
        text-transform: capitalize;
        margin-bottom: 0;
    }
    
    .chat-list a.d-flex {
        margin-bottom: 15px;
        position: relative;
        text-decoration: none;
    }
    
    .chat-list .active {
        display: block;
        content: '';
        clear: both;
        position: absolute;
        bottom: 3px;
        left: 34px;
        height: 12px;
        width: 12px;
        background: #00DB75;
        border-radius: 50%;
        border: 2px solid #fff;
    }
    
    .msg-head h3 {
        color: #222;
        font-size: 18px;
        font-weight: 600;
        line-height: 1.5;
        margin-bottom: 0;
    }
    
    .msg-head p {
        color: #343434;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.5;
        text-transform: capitalize;
        margin-bottom: 0;
    }
    
    .msg-head {
        padding: 15px;
        border-bottom: 1px solid #ccc;
    }
    
    .moreoption {
        display: flex;
        align-items: center;
        justify-content: end;
    }
    
    .moreoption .navbar {
        padding: 0;
    }
    
    .moreoption li .nav-link {
        color: #222;
        font-size: 16px;
    }
    
    .moreoption .dropdown-toggle::after {
        display: none;
    }
    
    .moreoption .dropdown-menu[data-bs-popper] {
        top: 100%;
        left: auto;
        right: 0;
        margin-top: 0.125rem;
    }
    
    .msg-body ul {
        overflow: hidden;
    }
    
    .msg-body ul li {
        list-style: none;
        margin: 15px 0;
    }
    
    .msg-body ul li.sender {
        display: block;
        width: 100%;
        position: relative;
    }
    
    .msg-body ul li.sender:before {
        display: block;
        clear: both;
        content: '';
        position: absolute;
        top: -6px;
        left: -7px;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 12px 15px 12px;
        border-color: transparent transparent #f5f5f5 transparent;
        -webkit-transform: rotate(-37deg);
        -ms-transform: rotate(-37deg);
        transform: rotate(-37deg);
    }
    
    .msg-body ul li.sender p {
        color: #000;
        font-size: 14px;
        line-height: 1.5;
        font-weight: 400;
        padding: 15px;
        background: #f5f5f5;
        display: inline-block;
        border-bottom-left-radius: 10px;
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
        margin-bottom: 0;
    }
    
    .msg-body ul li.sender p b {
        display: block;
        color: #180660;
        font-size: 14px;
        line-height: 1.5;
        font-weight: 500;
    }
    
    .msg-body ul li.repaly {
        display: block;
        width: 100%;
        text-align: right;
        position: relative;
    }
    
    .msg-body ul li.repaly:before {
        display: block;
        clear: both;
        content: '';
        position: absolute;
        bottom: 15px;
        right: -7px;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 12px 15px 12px;
        border-color: transparent transparent #72b763 transparent;
        -webkit-transform: rotate(37deg);
        -ms-transform: rotate(37deg);
        transform: rotate(37deg);
    }
    
    .msg-body ul li.repaly p {
        color: #fff;
        font-size: 14px;
        line-height: 1.5;
        font-weight: 400;
        padding: 15px;
        background: #72b763;
        display: inline-block;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        border-bottom-left-radius: 10px;
        margin-bottom: 0;
    }
    
    .msg-body ul li.repaly p b {
        display: block;
        color: #061061;
        font-size: 14px;
        line-height: 1.5;
        font-weight: 500;
    }
    
    .msg-body ul li.repaly:after {
        display: block;
        content: '';
        clear: both;
    }
    
    .time {
        display: block;
        color: #000;
        font-size: 12px;
        line-height: 1.5;
        font-weight: 400;
    }
    
    li.repaly .time {
        margin-right: 20px;
    }
    
    .divider {
        position: relative;
        z-index: 1;
        text-align: center;
    }
    
    .msg-body h6 {
        text-align: center;
        font-weight: normal;
        font-size: 14px;
        line-height: 1.5;
        color: #222;
        background: #fff;
        display: inline-block;
        padding: 0 5px;
        margin-bottom: 0;
    }
    
    .divider:after {
        display: block;
        content: '';
        clear: both;
        position: absolute;
        top: 12px;
        left: 0;
        border-top: 1px solid #EBEBEB;
        width: 100%;
        height: 100%;
        z-index: -1;
    }
    
    .send-box {
        padding: 15px;
        border-top: 1px solid #ccc;
    }
    
    .send-box form {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 15px;
    }
    
    .send-box .form-control {
        display: block;
        width: 85%;
        padding: 0.375rem 0.75rem;
        font-size: 14px;
        font-weight: 400;
        line-height: 1.5;
        color: #222;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ccc;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
    
    .send-box button {
        border: none;
        background: #72b763;
        padding: 0.375rem 5px;
        color: #fff;
        border-radius: 0.25rem;
        font-size: 14px;
        font-weight: 400;
        width: 24%;
        margin-left: 1%;
    }
    
    .send-box button i {
        margin-right: 5px;
    }
    
    .send-btns .button-wrapper {
        position: relative;
        width: 125px;
        height: auto;
        text-align: left;
        margin: 0 auto;
        display: block;
        background: #F6F7FA;
        border-radius: 3px;
        padding: 5px 15px;
        float: left;
        margin-right: 5px;
        margin-bottom: 5px;
        overflow: hidden;
    }
    section.message-area div#Open {
    opacity: 1;
}
    .send-btns .button-wrapper span.label {
        position: relative;
        z-index: 1;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        width: 100%;
        cursor: pointer;
        color: #343945;
        font-weight: 400;
        text-transform: capitalize;
        font-size: 13px;
    }
    
    #upload {
        display: inline-block;
        position: absolute;
        z-index: 1;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }
    
    .send-btns .attach .form-control {
        display: inline-block;
        width: 120px;
        height: auto;
        padding: 5px 8px;
        font-size: 13px;
        font-weight: 400;
        line-height: 1.5;
        color: #343945;
        background-color: #F6F7FA;
        background-clip: padding-box;
        border: 1px solid #F6F7FA;
        border-radius: 3px;
        margin-bottom: 5px;
    }
    
    .send-btns .button-wrapper span.label img {
        margin-right: 5px;
    }
    
    .button-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        text-align: center;
        margin: 0 auto;
    }
    
    button:focus {
        outline: 0;
    }
    
    .add-apoint {
        display: inline-block;
        margin-left: 5px;
    }
    
    .add-apoint a {
        text-decoration: none;
        background: #F6F7FA;
        border-radius: 8px;
        padding: 8px 8px;
        font-size: 13px;
        font-weight: 400;
        line-height: 1.2;
        color: #343945;
    }
    
    .add-apoint a svg {
        margin-right: 5px;
    }
    
    .chat-icon {
        display: none;
    }
    
    .closess i {
        display: none;
    }
    
    
    
    @media (max-width: 767px) {
        .chat-icon {
            display: block;
            margin-right: 5px;
        }
        .chatlist {
            width: 100%;
        }
        .chatbox {
            width: 100%;
            position: absolute;
            left: 1000px;
            right: 0;
            background: #fff;
            transition: all 0.5s ease;
            border-left: none;
        }
        .showbox {
            left: 0 !important;
            transition: all 0.5s ease;
        }
        .msg-head h3 {
            font-size: 14px;
        }
        .msg-head p {
            font-size: 12px;
        }
        .msg-head .flex-shrink-0 img {
            height: 30px;
        }
        .send-box button {
            width: 28%;
        }
        .send-box .form-control {
            width: 70%;
        }
        .chat-list h3 {
            font-size: 14px;
        }
        .chat-list p {
            font-size: 12px;
        }
        .msg-body ul li.sender p {
            font-size: 13px;
            padding: 8px;
            border-bottom-left-radius: 6px;
            border-top-right-radius: 6px;
            border-bottom-right-radius: 6px;
        }
        .msg-body ul li.repaly p {
            font-size: 13px;
            padding: 8px;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
            border-bottom-left-radius: 6px;
        }
    }
    </style>
    <script>
    jQuery(document).ready(function() {
    
        $(".chat-list a").click(function() {
            alert("test");
            $(".chatbox").addClass('showbox');
            return false;
        });
    
        $(".chat-icon").click(function() {
            $(".chatbox").removeClass('showbox');
        });
    
    
    });</script>