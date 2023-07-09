<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Toy's Pízza</title>
    <link rel="stylesheet" href="./estilos/style.css"/>
    <link
      rel="stylesheet"
      href="./css/bootstrap.min.css"
    />
    <script src="./src/app.js"></script>
  </head>
  <body>
    <!--Header/navbar-->
    <nav class="navbar navbar-expand-lg fixed-top" id="barra">
      <div class="container-fluid">
        <a class="navbar-brand" href="#" id="logo">Toy's Pizza</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Cocina</a>
            </li>
            <li>
              <a class="nav-link" href="#">Cierre</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Perfil
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
              </ul>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <button class="btn btn-outline" id="btn-carrito" type="button" data-bs-toggle="offcanvas" data-bs-target="#carrito" aria-controls="offcanvasScrolling">Resumen de compra</button>
          </form>
        </div>
      </div>
    </nav>
    <!--Cuerpo de la pagina-->
    <div class="container" id="cuerpo">
      <div class="container" id="cuerpo1">
        <!--Tarjetas-->
        <div class="row" id="renglon">
          <div class="col-12 col-md-5 col-lg-3 card" id="item">
            <span class="titulo-item">Pizza Peperoni</span>
            <img src="./src/img/pepe.jpg" alt="" class="img-item" />
            <span class="precio-item">Tamaño</span>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="mediana"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="mediana">mediana</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="grande"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="grande">Grande</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="extra"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="extra">Extra</label>
            <span class="precio-item">$</span>
            <button class="boton-item">Agregar al Carrito</button>
          </div>
          <div class="col-12 col-md-5 col-lg-3 card" id="item">
            <span class="titulo-item">Pizza Peperoni</span>
            <img src="./src/img/pepe.jpg" alt="" class="img-item" />
            <span class="precio-item">Tamaño</span>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="mediana"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="mediana">mediana</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="grande"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="grande">Grande</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="extra"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="extra">Extra</label>
            <span class="precio-item">$</span>
            <button class="boton-item">Agregar al Carrito</button>
          </div>
          <div class="col-12 col-md-5 col-lg-3 card" id="item">
            <span class="titulo-item">Pizza Peperoni</span>
            <img src="./src/img/pepe.jpg" alt="" class="img-item" />
            <span class="precio-item">Tamaño</span>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="mediana"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="mediana">mediana</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="grande"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="grande">Grande</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="extra"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="extra">Extra</label>
            <span class="precio-item">$</span>
            <button class="boton-item">Agregar al Carrito</button>
          </div> 
          <div class="col-12 col-md-5 col-lg-3 card" id="item">
            <span class="titulo-item">Pizza Peperoni</span>
            <img src="./src/img/pepe.jpg" alt="" class="img-item" />
            <span class="precio-item">Tamaño</span>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="mediana"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="mediana">mediana</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="grande"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="grande">Grande</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="extra"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="extra">Extra</label>
            <span class="precio-item">$</span>
            <button class="boton-item">Agregar al Carrito</button>
          </div>
          <div class="col-12 col-md-5 col-lg-3 card" id="item">
            <span class="titulo-item">Pizza Peperoni</span>
            <img src="./src/img/pepe.jpg" alt="" class="img-item" />
            <span class="precio-item">Tamaño</span>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="mediana"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="mediana">mediana</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="grande"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="grande">Grande</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="extra"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="extra">Extra</label>
            <span class="precio-item">$</span>
            <button class="boton-item">Agregar al Carrito</button>
          </div>
          <div class="col-12 col-md-5 col-lg-3 card" id="item">
            <span class="titulo-item">Pizza Peperoni</span>
            <img src="./src/img/pepe.jpg" alt="" class="img-item" />
            <span class="precio-item">Tamaño</span>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="mediana"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="mediana">mediana</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="grande"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="grande">Grande</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="extra"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="extra">Extra</label>
            <span class="precio-item">$</span>
            <button class="boton-item">Agregar al Carrito</button>
          </div>
          <div class="col-12 col-md-5 col-lg-3 card" id="item">
            <span class="titulo-item">Pizza Peperoni</span>
            <img src="./src/img/pepe.jpg" alt="" class="img-item" />
            <span class="precio-item">Tamaño</span>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="mediana"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="mediana">mediana</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="grande"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="grande">Grande</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="extra"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="extra">Extra</label>
            <span class="precio-item">$</span>
            <button class="boton-item">Agregar al Carrito</button>
          </div>
          <div class="col-12 col-md-5 col-lg-3 card" id="item">
            <span class="titulo-item">Pizza Peperoni</span>
            <img src="./src/img/pepe.jpg" alt="" class="img-item" />
            <span class="precio-item">Tamaño</span>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="mediana"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="mediana">mediana</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="grande"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="grande">Grande</label>
            <input
              type="radio"
              class="btn-check"
              name="tamaño"
              id="extra"
              autocomplete="off"
              checked
            />
            <label class="btn btn-outline-success" for="extra">Extra</label>
            <span class="precio-item">$</span>
            <button class="boton-item">Agregar al Carrito</button>
          </div>
          <div class="col-12 col-md-5 col-lg-3 card" id="item" style="opacity: 0;">
          </div>

        </div>
    </div>
    <!--CARRITOOOO-->
    <div
      class="offcanvas offcanvas-end"
      data-bs-scroll="true"
      tabindex="-1"
      id="carrito"
      aria-labelledby="offcanvasWithBothOptionsLabel"
    >
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">
          Resumen de compra
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="offcanvas"
          aria-label="Close"
        ></button>
      </div>
      <div class="offcanvas-body">
        <p>Try scrolling the rest of the page to see this option in action.</p>
      </div>
      <div>
        <button class="btn btn-primary" type="button">Proceder al pago</button>
      </div>
    </div>
    <script src="./js/bootstrap.bundle.js"></script>
  </body>
</html>
