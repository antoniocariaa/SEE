[comment]: # (Author: Antonio Caria)
[comment]: # (Created: 2024-04-20)

# Schema E-R e logico del database

## Schema E-R

L'analisi dei requisiti ha portato alla definizione di un modello E-R che rappresenta le entità coinvolte nel sistema informativo e le relazioni tra di esse.

### Progetto

![Schema E-R](assets/E-R%20DATABASE.png)

### Descrizione delle entità e delle relazioni

1. **Elettore**
    - Attributi:
        - id_elettore: int (PK)
        - codice_scheda_elettorale: int
        - codice_carta_identita: string
        - codice_patente: string
        - password: string
        - id_seggio: int
        - salt: string
        - tipo: string
    - Relazioni:
        - Membro di: **Seggio** (1, N)
        - Possiede: **SEE** (1, N)

2. **Seggio**
    - Attributi:
        - id_seggio: int (PK)
        - indirizzo: string
    - Relazioni:
        - Contiene: **Elettore** (N, 1)

3. **SEE**
    - Attributi:
        - id_see: int (PK)
        - pin: string
        - id_elettore: int
        - id_partito: int
        - preferenza_1: int
        - preferenza_2: int
        - data_voto: date
        - conteggiato: boolean
    - Relazioni:
        - Appartiene a: **Elettore** (N, 1)
        - Appartiene a: **Partito** (N, 1)
        - Vota: **Candidato** (2, N)

4. **Partito**
    - Attributi:
        - sigla: string (PK)
        - nome: string
        - simbolo: string
    - Relazioni:
        - Comprende: **SEE** (1, N)
        - Candida: **Candidato** (N, 1)

5. **Candidato**
    - Attributi:
        - id_candidato: int (PK)
        - nome: string
        - cognome: string
        - sesso: char
        - data_nascita: date
        - id_partito: string
    - Relazioni:
        - Candidato da: **Partito** (1, N)
        - Riceve voto da: **SEE** (N, 2)


## Schema logico

L'analisi dello schema E-R ha portato alla definizione dello schema logico del database, che comprende le tabelle e le relazioni tra di esse.

### Tabelle

Elettore(**#<ins>id_elettore</ins>**,tipo, codice_tessera_elettorale, codice_carta_identita, codice_patente, password, salt, **\*id_seggio**)

Seggio(**#<ins>id_seggio</ins>**, indirizzo)

SEE(**#<ins>id_see</ins>**, pin, data_voto, conteggiato, **\*id_elettore**, **\*id_partito**, **\*preferenza_1**, **\*preferenza_2**)

Partito(**#<ins>sigla</ins>**, nome, simbolo)

Candidato(**#<ins>id_candidato</ins>**, nome, cognome, sesso, data_nascita, **\*id_partito**)

### Vincoli

- Tabella "Elettore":
    - ON DELETE **SEGGIO** RESTRICT  
    - ON UPDATE **SEGGIO** CASCADE

- Tabella "SEE":
    - ON DELETE **ELETTORE** CASCADE
    - ON UPDATE **ELETTORE** CASCADE

    - ON DELETE **PARTITO** CASCADE
    - ON UPDATE **PARTITO** CASCADE

    - ON DELETE **CANDIDATO** SET NULL
    - ON UPDATE **CANDIDATO** CASCADE


- Tabella "Candidato":
    - ON DELETE **PARTITO** RESTRICT
    - ON UPDATE **PARTITO** CASCADE

