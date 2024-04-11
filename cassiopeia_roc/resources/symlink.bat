@echo off

rem Get the current template name by going one up in the folder
for %%I in (../.) do set templateName=%%~nxI

rem create folder junction after the template media files have been moved to the media folder
mklink /J "%~dp0..\media" %~dp0..\..\..\media\templates\site\%templateName%

pause