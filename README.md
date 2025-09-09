# ZX Image Manager
Zen Cart plugin that allows images to be uploaded from the admin section for whatever purposes (define pages, ez pages etc)

<p>ZX Image Manager was built for Zen Cart 2.0.0 or newer. It has not been tested on earlier versions, but should
        work with older versions using the appropriate set of file to install.</p>
    <p><strong>Before you proceed, make a backup of your database and files. Installation is done at your own
        risk.</strong></p>
    <p>Unzip the files from &quot;files&quot; directory to your computer. Connect to your server via FTP. <br>
        <strong>For Zen Cart v2.0 and newer:</strong> upload the content of zc_plugins directory to your website's zc_plugins directory and install using admin->Modules->Plugin Manager.<br>
        <strong>For Zen Cart 1.5.x:</strong> Check your admin directory name and rename the one in this package accordingly. Upload your files using your FTP
        client (I recommend using Filezilla) to the <strong>store root</strong>. Be careful, the store root directory on
        the server is where your store is installed, not necessarily domain root. After all files are in place, go to your admin section and the plugin will automatically install. You might need to refresh the screen or navigate to any admin page first.</p>
    <p>There are no core files affected or overwritten.</p>
    <p></p>

    <hr>

    <h3 id="usage"><strong>Usage</strong></h3>
    <p>After installation, go to admin-&gt;Tools-&gt;Image Manager.</p>
    <p>You will be able to upload new images to your main images directory or any already existing directory inside it.</p>
    <p>If you need to upload images to a directory that doesn't exist, you have to create the directory first.</p>
    <p>To browse the uploaded images, use the section below - select the folder you want to browse and click "View".</p>
    <p>Please note browsing the main images directory is restricted by default. You can enable it from admin->Configuration->Images->Image Manager: Allow Browsing Main Images Directory by setting the value to true, but keep in mind it might cause problems if you have a large number of images in that directory.</p>
    <p>Every image shows the HTML code which you can copy and use in your content as you wish.</p>
