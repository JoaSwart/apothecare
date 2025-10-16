<template>
  <div>
    <main>
      <section class="hero-section">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="container text-center">
            <span class="welcome-badge">
                Welkom bij Apothecare
            </span>
            <h1>
                Uw Gezondheid<br>
                <span class="highlight">Onze Zorg</span>
            </h1>
            <p class="subtitle">Uw betrouwbare online drogisterij & apotheek voor medicijnen, vitamines en verzorging</p>
            
            <div class="search-bar-wrapper">
                <input type="text" placeholder="Zoek op medicijn, klacht, product, merknaam...">
                <button>
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>
        </div>
      </section>

      <section class="features-section">
         <div class="container">
            <div class="features-grid three-cols">
                <div class="feature-card">
                    <div class="icon-wrapper green">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <h3>Betrouwbaar</h3>
                    <p>Kwalitatieve producten van vertrouwde merken</p>
                </div>
                <div class="feature-card" id="feature-card-blue">
                    <div class="icon-wrapper blue">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h3>Gratis verzending</h3>
                    <p>Vanaf €50 gratis aan huis geleverd</p>
                </div>
                <div class="feature-card">
                    <div class="icon-wrapper green">
                        <i class="fa-solid fa-robot"></i>
                    </div>
                    <h3>AI-Assistent</h3>
                    <p>24/7 persoonlijk advies en ondersteuning</p>
                </div>
            </div>
        </div>
      </section>

      <section class="news-section">
        <div class="container">
          <div class="section-header">
            <h2 class="section-title">Actueel</h2>
            <div class="carousel-nav">
              <button class="arrow-btn left" @click="prevSlide" ref="prevButton">
                <i class="fa-solid fa-chevron-left"></i>
              </button>
              <button class="arrow-btn right" @click="nextSlide" ref="nextButton">
                <i class="fa-solid fa-chevron-right"></i>
              </button>
            </div>
          </div>
          <div class="carousel-wrapper">
            <div class="news-grid" ref="track">
              <article class="news-card">
                <img src="../assets/vitamineproducten.jpg" alt="vitamineproducten">
                <div class="card-content">
                  <p class="date">14 okt 2025</p>
                  <h3>Nieuwe vitamineproducten aangekomen</h3>
                </div>
              </article>
              <article class="news-card">
                <img src="../assets/gezondewinter.jpg" alt="gezonde winter">
                <div class="card-content">
                  <p class="date">12 okt 2025</p>
                  <h3>Tips voor een gezonde winter</h3>
                </div>
              </article>
              <article class="news-card">
                <img src="../assets/kruidenthee.jpg" alt="kruidenthee">
                <div class="card-content">
                  <p class="date">10 okt 2025</p>
                  <h3>Biologische kruidenthee collectie</h3>
                </div>
              </article>
              <article class="news-card">
                <img src="../assets/aiassistent.png" alt="ai-assistent">
                <div class="card-content">
                  <p class="date">8 okt 2025</p>
                  <h3>AI-Assistent nu beschikbaar</h3>
                </div>
              </article>
            </div>
          </div>
        </div>
      </section>

       <section class="about-section">
             <div class="container text-center">
                <h2 class="section-title">Over Apothecare</h2>
                <p>Apothecare is uw betrouwbare online drogisterij & apotheek voor medicijnen, vitamines, verzorging en beauty producten. Met ons uitgebreide assortiment van meer dan 500 natuurlijke producten en onze innovatieve AI-assistent, bieden wij u de beste service en persoonlijk advies voor al uw gezondheidsbehoeften.</p>
            </div>
        </section>

        <section class="reviews-section">
            <div class="container text-center">
                <h2 class="section-title">Wat onze klanten zeggen</h2>
                <div class="features-grid three-cols">
                    <div class="review-card">
                        <div class="review-stars">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </div>
                        <p class="review-text">"Geweldige service en de AI-assistent heeft me perfect geholpen bij het vinden van de juiste supplementen. Super snelle levering ook!"</p>
                        <p class="review-author">- Anja de Vries</p>
                    </div>
                    <div class="review-card">
                        <div class="review-stars">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        </div>
                        <p class="review-text">"Eindelijk een online apotheek die betrouwbaar is en een groot assortiment heeft. Ik bestel hier voortaan al mijn verzorgingsproducten."</p>
                        <p class="review-author">- Peter Janssen</p>
                    </div>
                    <div class="review-card">
                        <div class="review-stars">
                            <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                        </div>
                        <p class="review-text">"Heel tevreden over de kwaliteit van de producten. De website is overzichtelijk en de bestelling was de volgende dag al in huis."</p>
                        <p class="review-author">- Simone Willems</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="categories-section">
             <div class="container text-center">
                <h2 class="section-title">Populaire Categorieën</h2>
                <p class="subtitle" style="margin-bottom: 40px;">Ontdek ons uitgebreide assortiment</p>
                
                <div class="category-grid">
                    <a href="#" class="category-card" style="background-image: url('../assets/supplementen.jpg');">
                        <div class="card-overlay">
                            <h3>Vitamines & Supplementen</h3>
                            <p>Voor optimale gezondheid</p>
                            <span>Bekijk producten &rarr;</span>
                        </div>
                    </a>
                     <a href="#" class="category-card" style="background-image: url('../assets/kruidentheendranken.jpg');">
                        <div class="card-overlay">
                            <h3>Kruidenthee & Dranken</h3>
                            <p>Natuurlijke ontspanning</p>
                            <span>Bekijk producten &rarr;</span>
                        </div>
                    </a>
                     <a href="#" class="category-card" style="background-image: url('../assets/aromatherapie.jpg');">
                        <div class="card-overlay">
                            <h3>Aromatherapy & Oliën</h3>
                            <p>Voor lichaam en geest</p>
                            <span>Bekijk producten &rarr;</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </main>
    
    <ChatWidget />
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue';
import ChatWidget from './ChatWidget.vue'; // Pas pad aan indien nodig

export default {
  name: 'LandingPage',
  components: {
    ChatWidget
  },
  setup() {
    const track = ref(null);
    const nextButton = ref(null);
    const prevButton = ref(null);
    const currentIndex = ref(0);

    const getVisibleCards = () => {
        if (window.innerWidth <= 768) return 1;
        if (window.innerWidth <= 992) return 2;
        return 3;
    };

    const updateCarousel = () => {
        if (!track.value || !prevButton.value || !nextButton.value) return;
        
        const cards = Array.from(track.value.children);
        if (cards.length === 0) return;

        const visibleCards = getVisibleCards();
        const cardWidth = cards[0].getBoundingClientRect().width;
        const gap = 30;
        const moveDistance = (cardWidth + gap) * currentIndex.value;

        track.value.style.transform = `translateX(-${moveDistance}px)`;
        prevButton.value.disabled = currentIndex.value === 0;
        nextButton.value.disabled = currentIndex.value >= cards.length - visibleCards;
    };

    const nextSlide = () => {
        const cards = Array.from(track.value.children);
        const visibleCards = getVisibleCards();
        if (currentIndex.value < cards.length - visibleCards) {
            currentIndex.value++;
            updateCarousel();
        }
    };

    const prevSlide = () => {
        if (currentIndex.value > 0) {
            currentIndex.value--;
            updateCarousel();
        }
    };

    const handleResize = () => {
        currentIndex.value = 0;
        updateCarousel();
    };

    onMounted(() => {
        updateCarousel();
        window.addEventListener('resize', handleResize);
    });

    onUnmounted(() => {
        window.removeEventListener('resize', handleResize);
    });

    return {
      track,
      nextButton,
      prevButton,
      nextSlide,
      prevSlide
    };
  }
};
</script>

<style>

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Poppins', sans-serif;
    background-color: #F8FBF8; 
    color: #2c3e50;
    line-height: 1.6;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

section {
    padding: 80px 0;
}

.text-center {
    text-align: center;
}

h1, h2, h3 {
    font-weight: 600;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 500;
    margin-bottom: 40px;
}

p {
    color: #596a7a;
}

.hero-section {
    padding: 120px 0;
    position: relative;
    overflow: hidden;
    background: linear-gradient(270deg, #dde4ec, #f4f6f5, #cfe0e0, #e6f5ef);
    background-size: 400% 400%;
    animation: gradientAnimation 15s ease infinite;
    display: flex; 
    justify-content: center;
    align-items: center;
    color: white; 
}

.hero-section::before,
.hero-section::after {
    content: '';
    position: absolute;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    filter: blur(80px); 
    z-index: 0; 
}

.hero-section::before {
    width: 300px;
    height: 300px;
    top: 10%;
    left: 10%;
    background-color: rgba(173, 216, 230, 0.3); 
}

.hero-section::after {
    width: 400px;
    height: 400px;
    bottom: 15%;
    right: 5%;
    background-color: rgba(144, 238, 144, 0.3); 
}

.hero-section .container {
    position: relative; 
    z-index: 1;
}

.hero-section .circle {
    position: absolute;
    border-radius: 50%;
    border: 2px solid rgba(30, 83, 33, 0.2);
    z-index: 0;
}

.hero-section .circle-1 {
    width: 100px;
    height: 100px;
    top: 50%;
    left: 15%;
    transform: translateY(-50%);
}

.hero-section .circle-2 {
    width: 50px;
    height: 50px;
    top: 60%;
    right: 18%;
    transform: translateY(-50%);
}

@keyframes gradientAnimation {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

.welcome-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: #edf3f1;
    color: #1e5321; 
    padding: 8px 16px;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 24px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.hero-section h1 {
    font-size: 4rem;
    line-height: 1.1;
    margin-bottom: 20px;
    color: #263238; 
    font-weight: 350;
}

.hero-section h1 .highlight {
    color: #1e5321; 
    font-size: 4.5rem;
    font-weight: 400;
}

.hero-section .subtitle {
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto 40px;
    color: #546e7a; 
}

.search-bar-wrapper {
    display: flex;
    max-width: 700px;
    margin: 0 auto;
    border: 1px solid #dcdcdc; 
    border-radius: 999px;
    overflow: hidden;
    background-color: #fff;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
}

.search-bar-wrapper input {
    flex-grow: 1;
    border: none;
    outline: none;
    padding: 20px 25px;
    font-size: 1rem;
    font-family: 'Poppins', sans-serif;
    color: #37474f;
}

.search-bar-wrapper button {
    background: linear-gradient(45deg, #5a867b, #5e88af); 
    border: none;
    margin: 10px;
    width: 2rem;
    height: 3rem;
    color: white;
    padding: 0 25px;
    cursor: pointer;
    border-radius: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.3s ease;
}

.search-bar-wrapper button:hover {
    background: linear-gradient(45deg, #527c71, #5881a7); 
}

.search-bar-wrapper button i {
    font-size: 22px; 
}

.icon-wrapper i {
    font-size: 25px; 
}

.features-section{
   z-index: 5;
   background-color: #ffffff;
   border-bottom: 1px solid #e0e0e0;
}

.features-grid {
    display: grid;
    gap: 30px;
}

.features-grid.three-cols {
    grid-template-columns: repeat(3, 1fr);
}

.feature-card {
    background-color: #fff;
    border: 1px solid #e0e0e0; 
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s, border 0.3s;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); 
}

.feature-card:hover {
    transform: translateY(-8px); 
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12); 
    border: 2px solid #a5d6a7; 
}

#feature-card-blue:hover{
    border-color: #90CAF9;
}

.feature-card .icon-wrapper {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    margin: 0 auto 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.icon-wrapper.green { 
     background: linear-gradient(45deg, #3e8b41, #6ca96f);
}

.icon-wrapper.blue { 
    background: linear-gradient(45deg, #1d84d8, #7cb0db);
}

.feature-card h3 {
    margin-bottom: 10px;
    font-size: 1.25rem;
    color: #37474f;
}

.news-section {
    background-color: #f9fafb; 
    border-top: 1px solid #eceff1; 
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
}

.carousel-nav .arrow-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    border: none;
    background-color: #37474f; 
    color: white;
    cursor: pointer;
    margin-left: 10px;
    transition: background-color 0.3s;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.carousel-nav .arrow-btn:hover {
    background-color: #455a64; 
}

.carousel-nav .arrow-btn:disabled {
    opacity: 0.4; 
    cursor: auto;
    background-color: #cfd8dc;
}

.carousel-wrapper {
    position: relative;
    overflow: hidden;
}

.news-grid {
    display: flex;
    gap: 30px;
    transition: transform 0.5s ease-in-out; 
    margin-top: 20px;
    margin-bottom: 20px;
}

.news-card {
    border: 1px solid #e0e0e0;
    border-radius: 16px;
    overflow: hidden;
    background-color: #fff;
    transition: transform 0.3s, box-shadow 0.3s;
    flex: 0 0 calc((100% / 3) - (60px / 3)); 
    min-width: calc((100% / 3) - (60px / 3));
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.news-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

.news-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
}

.news-card .card-content {
    padding: 25px;
}

.news-card .date {
    font-size: 0.9rem;
    margin-bottom: 8px;
    color: #78909c;
}

.news-card h3 {
    font-size: 1.2rem;
    line-height: 1.4;
    color: #37474f;
}

.about-section {
    background: linear-gradient(135deg, #f5f7fa 0%, #e0e8f0 100%); 
    border-top: 1px solid #e0e0e0;
    border-bottom: 1px solid #e0e0e0;
}

.about-section p {
    max-width: 800px;
    margin: 0 auto;
    font-size: 1.1rem;
    color: #546e7a;
}

.reviews-section {
    background-color: #ffffff; 
}

.review-card {
    background-color: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 16px;
    padding: 30px;
    text-align: left;
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.review-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.review-stars {
    color: #FFB300;
    margin-bottom: 15px;
    font-size: 1.2rem;
}

.review-text {
    font-style: italic;
    margin-bottom: 15px;
    color: #455a64;
}

.review-author {
    font-weight: 600;
    color: #263238; 
}

.categories-section {
    padding-bottom: 120px;
    background: linear-gradient(180deg, #F8FBF8 0%, #eef4f0 100%);
    border-top: 1px solid #e0e0e0;
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
}

.category-card {
    position: relative;
    height: 400px;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    align-items: flex-end;
    padding: 30px;
    text-decoration: none;
    color: white;
    background-size: cover;
    background-position: center;
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.category-card:hover {
    transform: scale(1.04); 
}

.category-card .card-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 60px 30px 30px;
    background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.3) 70%, transparent);
    text-align: left;
    transition: background 0.3s ease;
}

.category-card h3 {
    font-size: 1.5rem;
    margin-bottom: 5px;
    color: white;
}

.category-card p {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 15px;
}

.category-card span {
    font-weight: 600;
    color: #e0f2f1; 
    text-decoration: underline;
}

@media (max-width: 992px) {
    .features-grid.three-cols,
    .category-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .news-card {
        flex-basis: calc((100% / 2) - (30px / 2));
        min-width: calc((100% / 2) - (30px / 2));
    }
    .hero-section h1 {
        font-size: 3.5rem;
    }
    .hero-section h1 .highlight {
        font-size: 4rem;
    }
}

@media (max-width: 768px) {
    section {
        padding: 60px 0;
    }
    .hero-section h1 {
        font-size: 2.8rem;
    }
    .hero-section h1 .highlight {
        font-size: 3.2rem;
    }
    .features-grid.three-cols,
    .category-grid {
        grid-template-columns: 1fr;
    }
    .news-card {
        flex-basis: 100%;
        min-width: 100%;
    }
    .section-header {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
    .search-bar-wrapper {
        flex-direction: column;
        border-radius: 16px;
    }
    .search-bar-wrapper input {
        padding: 15px 20px;
        border-bottom: 1px solid #e0e0e0;
        border-radius: 16px 16px 0 0;
    }
    .search-bar-wrapper button {
        width: 100%;
        padding: 15px;
        border-radius: 0 0 16px 16px;
    }
}
</style>