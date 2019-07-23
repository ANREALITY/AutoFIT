AutoFIT
=======================

AutoFIT ist ein Bestellportal für Filetransfer-Schnittstellen, dessen Kernaufgabe die Abbildung des Vorgangs der Bestellung von Verbindungen bzw. Verbindungsschnittstellen ist.

Eine _Verbindung_ (auch _logische Verbindung_) ist die eigentliche und einzige Bestellposition und kann entweder eine **C**onnect**D**irect- oder eine **F**ile**T**ransfer**G**ate**W**ay-Verbindung sein. Jede _Verbindung_ hat zwei _Endpunkte_ – einen _Quellen-_ und einen _Zielendpunkt_. Ein _Endpunkt_ kann ein _interner_, ein _externer Server_ oder ein _Cluster_ sein. Ein _Cluster_ ist ein Bündel aus internen Servern, die über eine Adresse erreichbar sind.

Es ist eine Intranet-Web-Anwendung, geschrieben in PHP auf der Server- und HTML, CSS und JavaScript auf der Client-Seite, mit einer relationalen Datenbank (MySQL) als Datenspersistenzschicht.