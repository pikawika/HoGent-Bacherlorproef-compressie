# handleiding om .tex naar .pdf te compilen

In deze handlieding vind u hoe u de latex broncode van het voorstel omzet naar een pdf bestand om het te kunnen lezen.

## Nodige software installeren

Voor het compileren en bekijken van de Latex bronbestanden en de JabRef bibliografische databank heb je de juiste software nodig. Een handleiding vind u onder:

> [Handleiding te installeren software](../Software/)

## Command line instructies

1. Clone de repository naar uw toestel.
2. Open de terminal van uw toestel.
3. Navigeer naar de net geclonede github repo.
4. Navigeer naar: **voorstel/**
5. Run het volgende commando: **latexmk -pdf "bontinck\_lennert\_voorstel"**
6. Run het volgende commando: **biber "bontinck\_lennert\_voorstel"**
7. Run het volgende commando: **latexmk -pdf "bontinck\_lennert\_voorstel"**
8. U vindt de gegenereede pdf onder: **voorstel/bontinck\_lennert\_voorstel.pdf**


## Toch net niet duidelijk genoeg?
Bij het afwerken van een feature wordt ook steeds de meest recente pdf voorzien onder [PDFs](../../PDFs).