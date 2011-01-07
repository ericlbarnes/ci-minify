# CodeIgniter Minify

The goal of this project is to provide a simple way to minify and combine js and css files inside a CodeIgniter application. Currently other systems
exists but I wanted the compression to be part of my build process. So on deployments I compress and minify all the js and css. Then push off to s3
but this could also be useful to write them to a single file.

## Installation

Upload the Minify folder to your libraries folder. This is built using CI2 packages and you must be using CI2.

## Usage

Below is an overview of different usages:

Minify JS file
<pre>
$this->load->driver('minify');
$file = 'test/js/test1.js';
echo $this->minify->js->min($file);
</pre>

Minify CSS file
<pre>
$this->load->driver('minify');
$file = 'test/css/test1.css';
echo $this->minify->js->min($file);
</pre>

Minify and combine an array of files. Useful if you need files to be in a certain order.
<pre>
$this->load->driver('minify');
echo $this->minify->combine_files(array('test/css/test2.css', 'test/css/test1.css'));
</pre>

Minify and save a physical file
<pre>
$this->load->driver('minify');
$file = 'test/css/test1.css';
$contents = $this->minify->js->min($file);
$this->minify->save_file($contents, 'test/css/all.css');
</pre>

Minify an entire directory. The second param is an array of ignored files.
<pre>
$this->load->driver('minify');
echo $this->minify->combine_directory('test/css/, array('all.css'));
</pre>

## Credits

JS-Min - (https://github.com/rgrove/jsmin-php)