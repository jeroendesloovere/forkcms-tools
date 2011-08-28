Installation:

The installation procedure runs trough Terminal.

Start terminal and type:

# cd
# mkdir .forktool
# cd forktool
# git clone -b forktool git@github.com:jelmersnoeck/tools.git
# cd
# vi .bash_profile
// Add to the file (to type, press i, to save and exit press escape, type : followed by x)
// Change your username!
# alias ft=/Users/yourusername/.forktool/tools/ForkTool/ft.sh
// save the file
# source ~/.bash_profile

You can now start using ForkTool.

Using Forktool

To use ForkTool, you need to be in a project direcotry. This can be in the start, for example Projects/Myproject, but this can also be somewhere inside Fork, for example Projects/Myproject/default_www/frontend/modules

Once you're in your project directory, you can start using the commandos.

Currently available options:

ft module modulename
ft action [frontend/backend] modulename actionname
ft theme themename
ft widget modulename widgetname
ft show version