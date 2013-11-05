# Require any additional compass plugins here.

# Set this to the root of your project when deployed:
http_path = "."
css_dir = "."
sass_dir = "scss"
images_dir = "images"
javascripts_dir = "js"

# You can select your preferred output style here (can be overridden via the command line):
output_style = :compressed

preferred_syntax = :sass

# Sets up the file name based cache busting style we will use as:
# dir/file.1383642136.jpg where 1383642136 is the last modified timestamp for the file
asset_cache_buster do |path, real_path|
  if File.exists?(real_path)
    pathname = Pathname.new(path)
    modified_time = File.mtime(real_path).strftime("%s")
    new_path = "%s/%s.%s%s" % [pathname.dirname, pathname.basename(pathname.extname), modified_time, pathname.extname]

    {:path => new_path, :query => nil}
  end
end
