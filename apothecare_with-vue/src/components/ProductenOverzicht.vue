<template>
  <div>
    <main>
      <div class="top-products">
        <h3>Producten</h3>
        <form @submit.prevent>
          <div id="producten-zoek">
            <input
              class="zoekveld"
              type="search"
              v-model="searchTerm"
              placeholder="Zoek op product"
            />
            <button type="submit" class="product-search-btn">
              <i class="fa fa-search" aria-hidden="true"></i>
            </button>
          </div>
        </form>
      </div>

      <section class="mainframe">
        <article class="filters">
          <h4>Filter</h4>
          <hr id="filter-line" />

          <h4>Prijs</h4>
          <label v-for="p in prijsFilters" :key="p.value">
            <input
              type="checkbox"
              :value="p.value"
              v-model="selectedPrijs"
              class="filter"
            />
            {{ p.label }}
          </label>

          <h4>Categorie</h4>
          <label v-for="c in categorieFilters" :key="c.value">
            <input
              type="checkbox"
              :value="c.value"
              v-model="selectedCategorie"
              class="filter"
            />
            {{ c.label }}
          </label>

          <h4>Klachten</h4>
          <label v-for="k in klachtenFilters" :key="k.value">
            <input
              type="checkbox"
              :value="k.value"
              v-model="selectedKlachten"
              class="filter"
            />
            {{ k.label }}
          </label>
        </article>

            <article class="products">
              <div
                v-for="product in filteredProducts"
                :key="product.title"
                class="item"
              >
                <img :src="product.img" :alt="product.title" class="product-img" />
                <div class="product-tags">
                  <span class="tag" v-for="tag in product.klachten" :key="tag">{{ tag }}</span>
                </div>
                <h3 class="product-title">{{ product.title }}</h3>
                <p class="product-desc">{{ product.desc }}</p>
                <div class="product-info">
                  <span class="weight">{{ product.weight }}</span>
                  <span class="price">{{ product.price }}</span>
                </div>
                <button class="add-btn" @click="addToCart(product)">
                  <i class="fa-solid fa-cart-shopping"></i> Toevoegen
                </button>
              </div>
            </article>
      </section>
    </main>

    <site-footer></site-footer>
  </div>
</template>

<script>
export default {
  name: "ProductenOverzicht",
  data() {
    return {
      searchTerm: "",
      selectedPrijs: [],
      selectedCategorie: [],
      selectedKlachten: [],
      prijsFilters: [
        { value: "tot10", label: "€0 - €10" },
        { value: "10tot15", label: "€10 - €15" },
        { value: "15tot20", label: "€15 - €20" },
        { value: "20tot30", label: "€20 - €30" },
        { value: "30meer", label: "€30 en meer" },
      ],
      categorieFilters: [
        { value: "Aromatherapie", label: "Aromatherapie" },
        { value: "Kruidenthee", label: "Kruidenthee" },
        { value: "Supplementen", label: "Supplementen" },
        { value: "Vitaminens", label: "Vitaminens" },
        { value: "Voeding", label: "Voeding" },
      ],
      klachtenFilters: [
        { value: "Algemeen", label: "Algemene gezondheid" },
        { value: "Botgezondheid", label: "Botgezondheid" },
        { value: "Cholesterol", label: "Cholesterol" },
        { value: "Energie", label: "Energie" },
        { value: "Hartgezondheid", label: "Hartgezondheid" },
        { value: "Hoofdpijn", label: "Hoofdpijn" },
        { value: "Immuunsysteem", label: "Immuunsysteem" },
        { value: "Keelpijn", label: "Keelpijn" },
        { value: "Maagklachten", label: "Maagklachten" },
        { value: "Slaapproblemen", label: "Slaapproblemen" },
        { value: "Stress", label: "Stress" },
        { value: "Verkoudheid", label: "Verkoudheid" },
        { value: "Vermoeidheid", label: "Vermoeidheid" },
      ],
      products: [
        {
          title: "Vitamine D3 Capsules",
          desc: "Ondersteunt het immuunsysteem en bevordert sterke botten. Ideaal voor dagelijks gebruik.",
          img: "../../assets/img/vitamin3d.jpeg",
          prijs: "10tot15",
          categorie: "Vitaminens",
          klachten: ["Vermoeidheid", "Botgezondheid"],
          weight: "60g",
          price: "€14.99",
        },
        {
          title: "Biologische Kamillethee",
          desc: "Rustgevende thee voor ontspanning en betere slaap. 100% natuurlijke ingrediënten.",
          img: "../src/assets/img/kamillethee.jpeg",
          prijs: "tot10",
          categorie: "Kruidenthee",
          klachten: ["Stress", "Slaapproblemen", "Maagklachten"],
          weight: "100g",
          price: "€8.99",
        },
        {
          title: "Omega-3 Visolie",
          desc: "Rijk aan EPA en DHA voor hart- en hersengezondheid. Hoogwaardige kwaliteit.",
          img: "../src/assets/img/omega3.jpeg",
          prijs: "15tot20",
          categorie: "Supplementen",
          klachten: ["Concentratie", "Hartgezondheid", "Cholesterol"],
          weight: "90g",
          price: "€19.99",
        },
        {
          title: "Multivitamine Complex",
          desc: "Complete dagelijkse vitaminevoorziening in één capsule. Voor alle leeftijden.",
          img: "../src/assets/img/vitamion.jpeg",
          prijs: "15tot20",
          categorie: "Vitaminens",
          klachten: ["Vermoeidheid", "Algemeen", "Energie"],
          weight: "75g",
          price: "€16.99",
        },
        {
          title: "Etherische Lavendelolie",
          desc: "Kalmerende olie voor aromatherapie en ontspanning. 100% puur en natuurlijk.",
          img: "../src/assets/img/lavender.jpeg",
          prijs: "10tot15",
          categorie: "Aromatherapie",
          klachten: ["Stress", "Slaapproblemen", "Hoofdpijn"],
          weight: "30g",
          price: "€12.99",
        },
        {
          title: "Biologische honing",
          desc: "Pure biologische honing met antibacteriële eigenschappen. Lokaal geproduceerd.",
          img: "../src/assets/img/honing.jpeg",
          prijs: "10tot15",
          categorie: "Voeding",
          klachten: ["Keelpijn", "Verkoudheid", "Immuunsysteem"],
          weight: "250g",
          price: "€9.99",
        },
      ],
    };
  },
  computed: {
    filteredProducts() {
      return this.products.filter((p) => {
        const matchPrijs = this.selectedPrijs.length
          ? this.selectedPrijs.includes(p.prijs)
          : true;
        const matchCategorie = this.selectedCategorie.length
          ? this.selectedCategorie.includes(p.categorie)
          : true;
        const matchKlachten = this.selectedKlachten.length
          ? p.klachten.some((k) => this.selectedKlachten.includes(k))
          : true;
        const matchSearch = p.title
          .toLowerCase()
          .includes(this.searchTerm.toLowerCase());
        return matchPrijs && matchCategorie && matchKlachten && matchSearch;
      });
    },
  },
};
</script>

<style scoped>
/* Paste your entire CSS from style.css here */
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

body {
  font-family: sans-serif;
}

footer {
  background-color: #ffffff;
  display: flex;
  color: #000000;
  text-align: left;
  padding: 20px 0;
  position: relative;
  flex-wrap: wrap;
  justify-content: space-between;
  bottom: 0;
  width: 100vw;
  border-top: 1px solid #e0e0e0;
  font-family: Arial, sans-serif;
}

footer div {
  width: 30vw;
  padding: 0 40px;
}

.footer-title {
  font-size: 18px;
  margin-bottom: 15px;
  color: black;
  padding: 5px;
}
.footer-p {
  font-size: 16px;
  color: #52555e;
  padding: 5px;
}

.mainframe {
  display: flex;
  padding: 20px 0;
  width: 100%;
  height: 100vh;
}

.top-products {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-top: 10px;
  text-align: center;
  align-items: center;
}
.top-products h3 {
  padding-top: 40px;
  padding-bottom: 10px;
  font-size: 28px;
}

#producten-zoek {
  display: flex;
  align-items: center;
  width: fit-content;
  background-color: #f9fafb;
  border-radius: 999px;
  overflow: hidden;
}
.zoekveld {
  width: 400px;
  height: 45px;
  padding: 5px 10px;
  font-size: 16px;
  background-color: #f9fafb;
  border: none;
}
.product-search-btn {
  height: 45px;
  width: 45px;
  border: none;
  background-color: #f9fafb;
}
#zoekveld:focus {
  /* lichtgrijs randje ipv felblauw */
  outline: 2px solid #aaa;
}

.products {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-top: 10px;
  width: 75vw;
  /* justify-content: center; */
}

.filters {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-top: 10px;
  width: 25vw;
  padding: 10px 40px;
  box-sizing: border-box;
}
.filter {
  /* inputs */
  margin-right: 15px;
  align-items: center;
}
input[type="checkbox"] {
  accent-color: #2d7a4f;
  width: 18px;
  height: 18px;
  text-align: center;
}

.item {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  /* height: auto; */
  height: 560px;
  width: 330px;
  padding-bottom: 15px;
  display: flex;
  flex-direction: column;
  /* align-items: center; */
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.item:hover {
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
}

.product-img {
  width: 100%;
  height: 300px;
  object-fit: cover;
  border-bottom: 1px solid #eee;
  border-top-right-radius: 8px;
  border-top-left-radius: 8px;
  position: relative;
  z-index: 0;
}
.product-img:hover {
  transform: scale(1.03);
  transition: transform 0.3s ease-in-out;
}

.description {
  background-color: white;
  height: 40%;
  z-index: 1;
}

.product-tags {
  display: flex;
  gap: 5px;
  margin: 10px 15px 0 15px;
  flex-wrap: wrap;
}
.tag {
  background-color: #3c82c4;
  color: #ffffff;
  padding: 5px 10px;
  border-radius: 7px;
  font-size: 13px;
  font-weight: 900;
}

.product-title {
  font-size: 18px;
  font-weight: 500;
  margin: 10px 15px 0 15px;
  color: #000000;
}

.product-desc {
  font-size: 18px;
  color: #727787;
  margin: 10px 15px 0 15px;
  /* flex-grow: 1; */
}

.product-info {
  display: flex;
  justify-content: space-between;
  width: 85%;
  margin-top: 10px;
  font-size: 18px;
  color: #333;
  margin: 10px 15px 0 15px;
  flex-grow: 1;
}

.price {
  color: #2d7a4f;
}

.add-btn {
  background-color: #2d7a4f;
  width: 90%;
  color: #ffffff;
  border: none;
  border-radius: 8px;
  padding: 10px 20px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s ease;
  margin: 10px 15px 0 15px;
}
.add-btn:hover {
  background-color: rgb(70, 152, 104);
}

.hidden {
  display: none;
}

/* PRODUCT DETAILS */

.go-back {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 20px;
  background-color: white;
  color: #000000;
  height: 50px;
  width: 200px;
  padding: 10px;
  border-radius: 15px;
  text-decoration: none;
}
.go-back:hover {
  background-color: #2d7a4f;
  transition: 0.2s ease-in-out;
  color: white;
}

.product-detail-main {
  display: flex;
  flex-direction: column;
  width: 100%;
  padding: 20px 40px;
  gap: 20px;
  font-family: "Arial", sans-serif;
}

.product-detail-text {
  display: flex;
  flex-wrap: wrap;
  gap: 40px;
  align-items: flex-start;
}

.more-description {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.product-detail-img {
  height: 80vh;
  width: 40vw;
  /* object-fit: contain; */
  border-radius: 8px;
}

.img-desc-cont {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.more-desc-title {
  font-size: 24px;
  font-weight: 300;
  color: #000000;
}

.checks p {
  display: flex;
  align-items: center;
  gap: 20px;
  padding-top: 15px;
  font-size: 0.9rem;
  font-size: 20px;
  color: grey;
}

hr {
  border: none;
  border-top: 1px solid #ddd;
  margin: 10px 0;
}

.padding {
  padding: 10px 20px;
}
</style>
