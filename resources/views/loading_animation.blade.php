<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Skeleton screen effect</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="style.css" />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans&display=swap" rel="stylesheet">
    <style>
        * {
  padding: 0;
  margin: 0;
  font-family: 'IBM Plex Sans', sans-serif;
}
.row {
    display: block;
    position: relative;
    margin: 50px 0;
}
.container {
    width: 95%;
    max-width: 1240px;
    margin: auto;
}
.grid-row.grid-4-4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-gap: 20px;
}
.cards {
    background: #fff;
    height: auto;
    width: auto;
    overflow: hidden;
    box-shadow: 5px 8px 15px -10px rgba(0,0,0,0.25);
}
.card_image {
    width: 100%;
    height: 100%;
}
.card_image.loading {
    width: 100%;
    height: 180px;
}
.card_title {
    padding: 8px;
    font-size: 22px;
    font-weight: 700;
}
.card_title.loading {
    width: 50%;
    height: 1rem;
    margin: 1rem;
    border-radius: 3px;
    position: relative;
}
.card_description {
    padding: 8px;
    font-size: 16px;
}
.card_description.loading {
    height: 3rem;
    margin: 1rem;
    border-radius: 3px;
}
.loading {
    position: relative;
    background: #cccccc;
}
.loading:after {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%;
    transform: translateX(-100px);
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    animation: loading 0.8s infinite;
}
@keyframes loading {
    100% {
        transform: translateX(100%);
    }
}
    </style>
  </head>
  <body>
    <div class="row">
      <div class="container">
        <div class="grid-row grid-4-4">
          <div class="cards">
            <div class="card_image loading"></div>
            <div class="card_title loading"></div>
            <div class="card_description loading"></div>
          </div>
          <div class="cards">
            <div class="card_image loading"></div>
            <div class="card_title loading"></div>
            <div class="card_description loading"></div>
          </div>
          <div class="cards">
            <div class="card_image loading"></div>
            <div class="card_title loading"></div>
            <div class="card_description loading"></div>
          </div>
          <div class="cards">
            <div class="card_image loading"></div>
            <div class="card_title loading"></div>
            <div class="card_description loading"></div>
          </div>
          <div class="cards">
            <div class="card_image loading"></div>
            <div class="card_title loading"></div>
            <div class="card_description loading"></div>
          </div>
          <div class="cards">
            <div class="card_image loading"></div>
            <div class="card_title loading"></div>
            <div class="card_description loading"></div>
          </div>
          <div class="cards">
            <div class="card_image loading"></div>
            <div class="card_title loading"></div>
            <div class="card_description loading"></div>
          </div>
          <div class="cards">
            <div class="card_image loading"></div>
            <div class="card_title loading"></div>
            <div class="card_description loading"></div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>