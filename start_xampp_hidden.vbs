Set WshShell = CreateObject("WScript.Shell")

' Iniciar MySQL oculto
WshShell.Run "cmd /c C:\xampp\mysql_start.bat", 0, False

' Iniciar Apache oculto
WshShell.Run "cmd /c C:\xampp\apache_start.bat", 0, False