Set WshShell = CreateObject("WScript.Shell")

' Ejecutar el BAT oculto
WshShell.Run "cmd /c C:\xampp\htdocs\SGA\iniciar_proyecto.bat", 0, False