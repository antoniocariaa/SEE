[comment]: # (Author: Antonio Caria)
[comment]: # (Created: 2024-04-20)

# Analisi dei requisiti

## Introduzione

Il progetto consiste nella realizzazione di un prototipo funzionante di un'applicazione web per la procedura di voto per le elezioni politiche. In ogni seggio viene allestita una rete locale dove ogni elettore può effettuare in via telematica l'operazione di voto. La raccolta dei voti viene effettuata in una sede centralizzata.

## Requisiti funzionali

1. **Identificazione e autenticazione dell'elettore**
   - L'elettore deve essere identificato tramite la sua scheda elettorale e un documento di identità (carta d'identità, patente)
   - Dopo l'identificazione, all'elettore viene assegnato un PIN unico per accedere alla SEE

2. **Votazione**
    - L'elettore può effettuare la scelta del partito politico
    - L'elettore può indicare le preferenze (da 0 a 2) per i candidati

3. **Spoglio delle SEE**
    - Il sistema effettua autonomamente lo spoglio delle SEE
    - Viene prodotto l'esito delle elezioni, indicando per ogni partito i voti ottenuti in termini assoluti e in percentuale
    - Viene prodotto l'elenco dei candidati con i rispettivi voti ricevuti

4. **Statistiche**
    - Il sistema indica le percentuali dei votanti suddivisi per sesso
    - Il sistema indica le percentuali dei votanti suddivisi per fascia d'età
    - Il sistema indica le percentuali dei votanti suddivisi per fascia oraria di afflusso al seggio

## Requisiti non funzionali

1. **Sicurezza**
    - Il sistema deve garantire la sicurezza dei dati degli elettori
    - Il sistema deve garantire la sicurezza dei dati relativi ai voti
    - il sistema deve garantire la segretezza del voto e non collegarlo all'elettore

2. **Usabilità**
    - L'applicazione deve essere user-friendly
    - L'applicazione deve essere accessibile a tutti gli elettori

3. **Performance**
    - L'applicazione deve essere veloce e reattiva
    - L'applicazione deve supportare un numero elevato di elettori contemporaneamente

4. **Affidabilità**
    - Il sistema deve essere affidabile e non deve presentare malfunzionamenti

5. **Manutenibilità**
    - Il sistema deve essere facilmente manutenibile
    - Il sistema deve essere facilmente aggiornabile

6. **Portabilità**
    - L'applicazione deve essere accessibile da qualsiasi dispositivo connesso a Internet
    - L'applicazione deve essere accessibile da qualsiasi browser

## Requisiti di vincolo

1. **Tecnologie**
    - L'applicazione deve essere sviluppata utilizzando HTML, CSS, JavaScript e PHP
    - Il database deve essere implementato utilizzando MySQL

## Requisiti del sistema

1. **Requisiti hardware**
    - Il sistema deve essere installato su un server con le seguenti caratteristiche:
        - Processore: Intel Core i5 o superiore
        - RAM: 8 GB o superiore
        - Spazio su disco: 100 GB o superiore
        - Connessione Internet ad alta velocità
    
2. **Requisiti software**
    - Il sistema deve essere installato su un server con i seguenti software:
        - Sistema operativo: Linux (Ubuntu Server)
        - Web server: Apache
        - Database server: MySQL
        - Linguaggi di programmazione: HTML, CSS, JavaScript, PHP



