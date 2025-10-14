# Documento de entrega – Projectweek Apothecare

## 1. Projectnaam

**Apothecare** – Online gezondheidswebshop gericht op welzijn en dagelijkse gezondheid.

---

## 2. Algemeen concept

Apothecare is een webshop die gezondheidsproducten aanbiedt.

- **AI-chat:** zwevende knop rechtsonder, gebruikers kunnen vragen stellen.  
- **Design:** geoptimaliseerd voor oudere gebruikers (grote knoppen, overzichtelijke interface).

---

## 3. Ontwerp en visuele stijl

**Kleurenpalet:**

- Groen (30%) – gezondheid, natuur  
- Blauw (30%) – vertrouwen, rust  
- Wit (60%) – duidelijkheid  
- Accentkleur (10%) – voor knoppen/iconen, nog te bepalen

**Algemene stijl:**

- Minimalistisch, overzichtelijk  
- Hoog contrast, leesbaar lettertype  
- Toegankelijkheid voor ouderen

---

## 4. Pagina’s en hoofdonderdelen

### 4.1 Homepagina

- Productlijst: naam, afbeelding, beschrijving, gram, prijs, klachten/doeleinden  
- Horizontaal scrollende afbeeldingen van populaire producten  
- Winkelmandje (zijvenster met geselecteerde producten en totaal)  
- “Over ons”-sectie onderaan  
- AI-chatknop rechtsonder  
- Footer met contactinformatie

### 4.2 Productdetailpagina

- Uitgebreide productinformatie, klachten/doeleinden  
- Product toevoegen aan winkelmandje

### 4.3 Beheerderspagina (Dashboard)

- Login verplicht  
- Productbeheer: bekijken, toevoegen, bewerken, verwijderen  
- Bestellingen bekijken  
- Gebruikersprofielen beheren  
- Simulatie van betalingen (virtuele portemonnee €100 voor nieuwe klanten)

### 4.4 Loginpagina

- Toegankelijk voor beheerders  
- Veilig gekoppeld aan database

---

## 5. Technische componenten

- **AI-chat:** Ollama Mistral Instruct 7B, zwevende knop, basisinformatie  
- **Database:** Tabellen voor producten, beheerders, klanten

---

## 6. Taakverdeling team

| Naam     | Taak                                  |
|----------|--------------------------------------|
| Servinio | Documentatie, ondersteuning           |
| Joa      | Frontendontwikkeling, documentatie    |
| Julia    | Frontend & backend                    |
| Shainy   | AI-componenten & databasebeheer       |
| Eric     | Backendontwikkeling & implementatie  |

---

## 7. Functionele eisen

- Productzoeken, filters, informatiepagina’s  
- Bestellen & accountbeheer  
- Medewerker/Apotheker: bestellingen inzien, voorraad beheren  
- Beheerder: gebruikersrollen en productbeheer  
- Overige: responsive, snel laden, toegankelijk, AI-chat permanent beschikbaar

---

## 8. User Stories

- Producten opzoeken, bestellen, accountbeheer  
- Chat met AI, contact opnemen met medewerker  
- Bestelstatus volgen, voorraad bijwerken, meldingen ontvangen

---

## 9. Use Cases (kort overzicht)

### 9.1 Producten bestellen

Gebruiker logt in → zoekt product → winkelmandje → levermethode → gegevens → betalen → bevestiging → Apotheker verwerkt bestelling

### 9.2 Bestelstatus volgen

Gebruiker logt in → “Mijn bestellingen” → kiest bestelling → status tonen → notificatie bij verandering

### 9.3 AI-chatbot gebruiken

Bezoeker opent website → klikt AI-knop → chatvenster opent → vraag stellen → AI antwoordt

### 9.4 Voorraad bijwerken (Apotheker)

Apotheker logt in → productbeheer → product selecteren → hoeveelheid aanpassen → bevestigen → voorraad bijgewerkt

---

## 10. Wireframes

De wireframe-afbeeldingen voor Homepagina, Productdetailpagina en Dashboard staan in het PDF-document.  
In dit document staat enkel de tekstuele beschrijving.
