# SEE - Scheda Elettorale Elettronica

Un prototipo di sistema di votazione elettronico realizzato come progetto scolastico durante le scuole superiori. Il progetto mira a digitalizzare e semplificare il processo elettorale, offrendo un'interfaccia intuitiva per gli elettori e strumenti di gestione per gli amministratori.

## Indice
- [Introduzione](#introduzione)
- [Nota sui dati e marchi](#nota-sui-dati-e-marchi)
- [Funzionalità Principali](#funzionalità-principali)
  - [Area Elettore](#area-elettore)
  - [Area Amministratore](#area-amministratore)
- [Struttura del Progetto](#struttura-del-progetto)
- [Documentazione](#documentazione)
- [Disclaimer](#disclaimer)

## Introduzione
Questo software è nato con l'idea di simulare una vera e propria votazione tramite un sistema informatico web. Permette agli elettori di registrarsi, accedere e compilare la propria scheda elettorale in modo digitale. Allo stesso tempo, fornisce a chi gestisce il sistema un pannello di controllo per organizzare le liste e visualizzare l'andamento dei voti.

## Nota sui dati e marchi
> ⚠️ **Avvertenza:** I dati presenti nel database fornito per il testing del sistema, così come eventuali marchi, loghi o riferimenti alle istituzioni della Repubblica Italiana, sono stati inseriti esclusivamente a **scopo didattico e dimostrativo** durante lo sviluppo del progetto scolastico. Essi non hanno alcuna valenza reale, ufficiale o politica.

## Funzionalità Principali

Il sistema offre funzionalità distinte differenziate in due ruoli principali: Utenti (elettori) e Amministratori.

### Area Elettore
- **Autenticazione:** Gli utenti possono registrarsi, effettuare il login e scollegarsi in modo sicuro.
- **Compilazione Scheda Elettorale:** Un'interfaccia guidata e digitale permette all'elettore di esprimere il proprio voto, selezionando un partito politico e consultando le liste collegate.
- **Preferenze Candidati:** Possibilità di esprimere preferenze specifiche per i candidati appartenenti alla lista o partito selezionato.
- **Riepilogo e Conferma:** Il sistema fornisce una schermata riepilogativa prima della conferma definitiva per evitare la registrazione di voti errati.

### Area Amministratore
L'amministratore ha a disposizione un vero e proprio "Pannello di Controllo" multifunzione:
- **Gestione Partiti:** Inserimento di nuovi partiti, aggiornamento dei dati e rimozione dal database.
- **Gestione Candidati:** Aggiunta, modifica o eliminazione dei candidati associati ai vari schieramenti.
- **Gestione Seggi:** Strumenti dedicati alla configurazione dei seggi elettorali.
- **Spoglio in Tempo Reale:** Una sezione interamente dedicata allo spoglio, che permette di visualizzare i conteggi dei voti, i risultati e le statistiche elettorali accumulate.

## Struttura del Progetto
- `src/`: Contiene l'intero codice sorgente del sito web (scritto principalmente in PHP) incluse le pagine e la logica di connessione al database.
- `Database/`: Contiene i dump SQL necessari alla configurazione e creazione della base di dati (`votazioni.sql`).
- `DOCS/`: Contiene gli allegati e la documentazione originale legata alla stesura del progetto scolastico.

## Documentazione
Tutta la documentazione tecnica prodotta nella fase di studio, come l'**Analisi dei Requisiti**, il **Modello E-R logico**, e i diagrammi strutturali e dell'attore (**UML**), è raggruppata e consultabile all'interno della cartella `DOCS/`.

---

## Disclaimer
**ATTENZIONE:** *Questo sistema di voto elettronico (SEE) è un **prototipo (Proof of Concept) nato in ambito scolastico a scopo di studio e valutazione didattica**.* 
*Il codice sorgente e la struttura del database **non** presentano i livelli di sicurezza, privacy, cifratura e affidabilità necessari a far fronte a elezioni e votazioni reali (pubbliche o private).*
*L'autore declina qualsivoglia responsabilità legata all'utilizzo improprio del software, del database, o di eventuali asset protetti da copyright presenti nei rami di sviluppo originali.*
