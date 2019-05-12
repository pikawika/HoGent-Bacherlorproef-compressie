# handleiding om .tex naar .pdf te compilen

In deze handlieding vind u hoe u de latex broncode van het voorstel omzet naar een pdf bestand om het te kunnen lezen.

## Nodige software installeren

Voor het compileren en bekijken van de Latex bronbestanden en de JabRef bibliografische databank heb je de juiste software nodig. Een handleiding vind u onder:

> [Handleiding te installeren software](../software/)

## Command line instructies

**HOTFIX:** theme opgelegd door HoGent bevat een fout. Deze fout kan impact hebben vanaf stap 1 en/of na stap 6 en mogelijks bij eldere stappen. indien je errors krijgt bij compilen kan je best na elke stap volgende controleren: Ga naar de file bachelorproef_bontinck_lennert.gls en verwijder de regel   \setcounter{page}{df}

Indien u een mac gebruiker bent kan u het generate.sh script gebruiken! Anders kan u volgend stappenplan gebruiken.

1. Clone de repository naar uw toestel.
2. Open de terminal van uw toestel.
3. Navigeer naar de net geclonede github repo.
4. Navigeer naar: **bachelorproef/**
5. Run het volgende commando: **latexmk -pdf "bachelorproef\_bontinck\_lennert"**
6. Run het volgende commando: **makeglossaries -pdf "bachelorproef\_bontinck\_lennert"**
7. Run het volgende commando: **biber "bachelorproef\_bontinck\_lennert"**
8. Run het volgende commando: **latexmk -pdf "bachelorproef\_bontinck\_lennert"**

Na het runnen van het script of het uitvoeren van bovenstaande stappen kan u de pdf met alle bronnen via textstudio compilen!


## Toch net niet duidelijk genoeg?
Bij het afwerken van een feature wordt ook steeds de meest recente pdf voorzien onder [PDFs](../../PDFs).
