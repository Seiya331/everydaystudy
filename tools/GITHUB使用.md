#安装
mac ox  homebrew install git

linux apt-get install git


#创建版本库

```

mkdir gitversion

git init

git add readme.tx
t
git commit -m '增加代码'

git log --pretty=oneline

	#查找版本号
git reflog

	#丢弃工作修改
git checkout -- readme.txt

	#推送
git remote add origin git@github.com:Seiya331/everydaystudy.git
git push -u origin master

```