# Installatie van de nodige software

Er is gebruik gemaakt van Letex en JabRef voor het maken van de verschillende bachelorproef onderdelen. 

Indien u zelf de broncode wilt bekijken heeft u dus enkele programma's nodig. Instructies hoe u dit doet vind u hier.

## Inhoudsopgave

- [Downloads en installatie](#downloads-en-installatie)
    - [Downloads en installatie: Windows](#downloads-en-installatie-windows)
    - [Downloads en installatie: Windows](#downloads-en-installatie-windows-1)
    - [Downloads en installatie: Ubuntu/Debian](#downloads-en-installatie-ubuntu-debian)
    - [Downloads en installatie: Fedora](#downloads-en-installatie-fedora)
- [Configuratie](#configuratie)
    - [Configuratie: GIT](#configuratie-git)
    - [Configuratie: TeXStudio](#configuratie-texstudio)
    - [Configuratie: JabRef](#configuratie-jabref)

## Downloads en installatie

### Downloads en installatie: Windows

Installeer volgende programma's: 

- [Git client](https://git-scm.com/download/win)
- [Latex compiler](https://miktex.org/download)
- [TeXStudio](http://www.texstudio.org/)
- [JabRef](https://www.fosshub.com/JabRef.html)

### Downloads en installatie: Windows 

Installeer volgende programma's: 

- [Git client](https://git-scm.com/download/mac)
- [Latex compiler](https://www.tug.org/mactex/mactex-download.html)
- [TeXStudio](http://www.texstudio.org/)
- [JabRef](https://www.fosshub.com/JabRef.html)

### Downloads en installatie: Ubuntu/Debian

Voer volgende commands in terminal uit: 

````
sudo aptitude update
````
````
sudo aptitude install git texlive-latex-base texstudio jabref
````

### Downloads en installatie: Fedora

Voer volgende command in terminal uit: 

````
sudo dnf install git texstudio jabref \texlive-collection-latex texlive-babel-dutch
````

## Configuratie

### Configuratie: GIT

Aangezien deze repository op private staat heeft u toegang nodig om hem te clonen. Dit wilt zeggen dat u moet aangemeld zijn in GIT bash. U vind er meer over op:

> [De officiële git help website](https://help.github.com/articles/set-up-git/)

### Configuratie: TeXStudio

Volgende instellingen (onder Options > Configure TeXstudio) moeten zeker ingesteld zijn:

- Build–Default 
    - Compiler: pdflatex–Default 
    - Bibliography tool: biber
- Editor:
    - Indentation mode: Indent and Unindent Automatically
    - Replace Indentation Tab by Spaces: true
    - Replace Tab in Text by spaces: true
    - Replace Double Quotes: English Quotes

### Configuratie: JabRef

Bij het openen van de bibliografische databank zeker controleren dat u het volgende hebt gedaan:

> File > Switch to BibLaTeXmode