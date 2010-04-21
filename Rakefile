require 'rubygems'
require 'rake'

task :default => :test

desc "Run all tests"
task :test do
  system "phpunit --colors #{Dir['test/**/*.php'].join(" ")}"
end

desc "Generate encoded value"
task :encode do
  system "php -f encode.php"
end