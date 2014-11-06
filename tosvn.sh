CURRENTDIR=`pwd`
SVNPATH="/tmp/mantissvn"
SVNURL="http://plugins.svn.wordpress.org/mantis-ad-network"
README=`grep "^Stable tag:" README.txt | awk -F' ' '{print $NF}'`
PHP=`grep "Version:" mantis.php | awk -F' ' '{print $NF}'`

if [ "$README" != "$PHP" ]; then echo "Version in README.txt & mantis.php don't match. Exiting...."; exit 1; fi

grep "= $PHP =" README.txt >/dev/null 2>&1

if [ ! $? -eq 0 ]; then
	echo "Forgot to add revision log entry"
fi

rm -rf $SVNPATH

echo "Checking out plugin"
svn co --non-recursive $SVNURL $SVNPATH

cd $SVNPATH
svn update trunk/
svn update --depth=immediates tags/

cd $CURRENTDIR

echo "Exporting the HEAD of master from git to the trunk of SVN"
git checkout-index -a -f --prefix=$SVNPATH/trunk/

cd $SVNPATH

cd trunk

svn st | grep ^? | sed 's/?    //' | xargs svn add

svn commit -m "Preparing for $PHP release"

if [ $? -eq 0 ]; then
	echo "Creating new SVN tag and committing it"
	
	svn copy $SVNURL/trunk/ $SVNURL/tags/$PHP/ -m "Tagging version $PHP"
fi

echo "Removing temporary directory $SVNPATH"
rm -rf $SVNPATH/
