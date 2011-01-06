# CodeIgniter Minify

The goal of this project is to provide a simple way to minify and combine js and css files inside a CodeIgniter application. Currently other systems
exists but I wanted to the compression to be part of my build process. So on deployments I compress and minify all the js and css. Then push off to s3
but this could also be useful to write them to a single file.

## Installation

Upload the Minify folder to your libraries folder. This is built using CI2 packages and you must be using CI2.

## Usage

Below is an overview of different usages:

<pre>
// Minify JS file
$this->load->driver('minify');
$file = 'test/js/colorbox.js';
echo $this->minify->js->min($file);
</pre>

<pre>
// Minify CSS file
$this->load->driver('minify');
$file = 'test/css/colorbox.css';
echo $this->minify->js->min($file);
</pre>

<pre>
// Minify and combine directory of files
$this->load->driver('minify');
$this->minify->combine_directory('test/css');
</pre>

<pre>
// Minify and save a physical file
$this->load->driver('minify');
$file = 'test/css/colorbox.css';
$contents = $this->minify->js->min($file);
$this->minify->save_file($contents, 'test/css/all.css');
</pre>

<pre>
// Minify an entire directory
$this->load->driver('minify');
$this->minify->combine_directory('test/css/, 'all.css');
</pre>

## Credits

JS-Min - https://github.com/rgrove/jsmin-php