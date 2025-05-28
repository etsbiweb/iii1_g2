<?php
// Primjer podataka koje ćemo ispisati
$podaci = [
    ["ime" => "Ivan", "prezime" => "Ivić", "email" => "ivan.ivic@example.com"],
    ["ime" => "Ana", "prezime" => "Anić", "email" => "ana.anic@example.com"],
    ["ime" => "Marko", "prezime" => "Marković", "email" => "marko.markovic@example.com"],
];
?>
<style>@import 'https://fonts.googleapis.com/css?family=Ubuntu:300, 400, 500, 700';

*, *:after, *:before {
  margin: 0;
  padding: 0;
}

.svg-container {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  z-index: -1;
}

svg {
  path {
    transition: .1s;
  }

  &:hover path {
    d: path("M 800 300 Q 400 250 0 300 L 0 0 L 800 0 L 800 300 Z");
  }
}

body {
    color: yellow;
  color: #333;
  font-family: 'Ubuntu', sans-serif;
  position: relative;
}

h3 {
  font-weight: 400;
}

header {
  color: white;
  padding-top: 10vw;
  padding-bottom: 30vw;
  text-align: center;
}

main {
  background: linear-gradient(to bottom, #ffffff 0%, #dddee1 100%);
  border-bottom: 1px solid rgba(0, 0, 0, .2);
  padding: 10vh 0 80vh;
  position: relative;
  text-align: center;
  overflow: hidden;

  &::after {
    border-right: 2px dashed #eee;
    content: '';
    position: absolute;
    top: calc(10vh + 1.618em);
    bottom: 0;
    left: 50%;
    width: 2px;
    height: 100%;
  }
}

footer {
  background: #dddee1;
  padding: 5vh 0;
  text-align: center;
  position: relative;
}

small {
  opacity: .5;
  font-weight: 300;

  a {
    color: inherit;
  }
}
        th, td {
            border: 1px solid #ff9800; /* Narančasta boja za granice */
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #ffeb3b; /* Žuta boja za zaglavlja */
        }
        tr:nth-child(even) {
            background-color: #fff; /* Bijela boja za parne redove */
        }
        tr:nth-child(odd) {
            background-color: #fff8e1; /* Svijetlo žuta boja za neparne redove */
        }
        .ispis{
            font-size: 38px;
            font-weight: bold;
        }
        .naslov {
            font-size: 40px;
            font-weight: bold;
            color: #333;
        }
    </style>
</style>
<body>
  <div class="svg-container">
    <!-- I crated SVG with: https://codepen.io/anthonydugois/pen/mewdyZ -->
    <svg viewbox="0 0 800 400" class="svg">
      <path id="curve" fill="#e8f272" d="M 800 300 Q 400 350 0 300 L 0 0 L 800 0 L 800 300 Z">
      </path>
    </svg>
  </div>

  <header>
    <h1 class="naslov">Okusite domaće – probajte naše recepte!</h1>
    <h3 class="naslov">Svaki zalogaj priča našu priču.</h3>
  </header>

  <main>
    <p class="ispis">ISPIS</p>
    <!--  -->
<?php




                        $qSelect = $konekcija->prepare('SELECT * FROM `recepti` ;');
                        $qSelect->execute();
                        $automobili = $qSelect->fetchAll(PDO::FETCH_ASSOC);
                        if(!empty($automobili)){
                            foreach($automobili as $auto){
                            ?>         
                    <tr>
                        <td><?php echo htmlspecialchars($auto['id']);?></td>
                        <td><?php echo htmlspecialchars($auto['ime_umjetnika']);?></td>
                        <td><?php echo htmlspecialchars($auto['ime_recepta']);?></td>
                        <td><?php echo htmlspecialchars($auto['sastojci']);?></td>
                        <td><?php echo htmlspecialchars($auto['piprema']);?></td>
                        <td><?php echo htmlspecialchars($auto['slika']);?></td>
                       
                        <td><a href="uredi.php?id=<?php echo htmlspecialchars($auto['id']);?>">Uredi</a></td>
                        <td><a href="obrisi.php?id=<?php echo htmlspecialchars($auto['id']);?>">Obrisi</a></td>
                        
                        <?php
                            }
                        }
                        ?>
    <!--  -->

  </main>


<table>
        <thead>
            <tr>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($podaci as $osoba): ?>
                <tr>
                    <td><?php echo htmlspecialchars($osoba['ime']); ?></td>
                    <td><?php echo htmlspecialchars($osoba['prezime']); ?></td>
                    <td><?php echo htmlspecialchars($osoba['email']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
  <footer>
    <p>Recepti s dušom – probajte sad!</p>
   
  </footer>
  <script>
    (function() {
  // Variables
  var $curve = document.getElementById("curve");

  var last_known_scroll_position = 0;

  var defaultCurveValue = 350;

  var curveRate = 3;

  var ticking = false;

  var curveValue;

  // Handle the functionality
  function scrollEvent(scrollPos) {
    if (scrollPos >= 0 && scrollPos < defaultCurveValue) {
      curveValue = defaultCurveValue - parseFloat(scrollPos / curveRate);
      $curve.setAttribute(
        "d",
        "M 800 300 Q 400 " + curveValue + " 0 300 L 0 0 L 800 0 L 800 300 Z"
      );
    }
  }

  // Scroll Listener
  // https://developer.mozilla.org/en-US/docs/Web/Events/scroll
  window.addEventListener("scroll", function(e) {

    last_known_scroll_position = window.scrollY;

    if (!ticking) {
      window.requestAnimationFrame(function() {

        scrollEvent(last_known_scroll_position);

        ticking = false;
      });
    }

    ticking = true;
  });

})();

  </script>



</body>