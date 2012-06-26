#!/usr/bin/perl

# menubuild.pl
# bulids the structure of the menu by globbing in
# levels of a directory

use File::Spec;

# standard attributes for all initial menu items
# the class tag is left open so you can add more classes
# but you must remember to close the tag too
my $STD_ATTR = "onclick='add_text(this)' class='unchecked";

# path to highest level of texts
my $DATA_DIR = "../data/sortByWord/discardTagged/none/";
my $CRAP = "_discardTagged_none_w.csv";

# burn in the first few lines including the entire corpus
print "<ul>\n";
print "\t<li><span id='Entire_Corpus' $STD_ATTR sub1'>Entire_Corpus</span>\n";
print "\t\t<ul>\n";

# grab the subfolders corresponding to the genres
my @genres = <$DATA_DIR*/>;
for $genre(@genres) {

	# yank out the genre name
	$genre =~ /\/(.\_.*)\/$/;
	my $genre_name = $1;
	#print "$genre_name\n";
	
	print "\t\t\t<li><span id='$genre_name' $STD_ATTR sub2'>$genre_name</span>\n";
	print "\t\t\t\t<ul>\n";
	
	# grab the directories in the current directory, corresponding to the manuscript number
	my @manuscripts = <$genre*/>;
	for $manuscript(@manuscripts) {

		# yank out the manuscript number
		$manuscript =~ /$genre_name\/(.*)\/$/;
		my $manuscript_number = $1;
		#print "$manuscript_number\n";

		print "\t\t\t\t\t<li><span id='$manuscript_number' $STD_ATTR sub3'>$manuscript_number</span>\n";
		print "\t\t\t\t\t\t<ul>\n";

		# grab all the csv files, each text
		my @texts = <$manuscript*>;
		for $text(@texts) {

			# get the file/text name without the stat info 
			$text =~ /$manuscript_number\/(.*)$CRAP$/;
			$text_name = $1;
			
			# we only want the texts not the csv for the whole manuscript number
			if ( $text_name =~ /_T\d{5}/ ) {

				print "\t\t\t\t\t\t\t<li><span id='$text_name' $STD_ATTR sub4'>$text_name</span></li>\n";

			}

		}

		print "\t\t\t\t\t\t</ul>\n";
		print "\t\t\t\t\t</li>\n";

	}

	print "\t\t\t\t</ul>\n";
	print "\t\t\t</li>\n";

}

print "\t\t</ul>\n";
print "\t</li>\n";
print "</ul>\n";
