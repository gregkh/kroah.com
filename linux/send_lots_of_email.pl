#!/usr/bin/perl -w

# horrible hack of a script to send off a large number of email messages, one after
# each other, all chained together.  This is useful for large numbers of patches.
#
# Use at your own risk!!!!
#
# greg kroah-hartman Jan 8, 2002
# <greg@kroah.com>
# 
# updated to give a valid subject and CC the owner of the patch - Jan 2005
# first line of the message is who to CC, 
# and second line is the subject of the message.
# 

# modify these options each time you run the script
$to = 'my-favorite-email_list@somewhere.baz.nowhere';
$initial_reply_to = '<20050203173208.GA23964@foobar.com>';
$initial_subject = "[PATCH] Foo fixes for 2.6.11-rc3";
@files = (
"rev-1.2041.patch",
"rev-1.2042.patch",
"rev-1.2043.patch",
"rev-1.2044.patch",
"rev-1.2045.patch",
"rev-1.2046.patch",
);

# change this to your email address.
$from = "SOMEONE <someone\@somewhere.com>";

# Usually don't need to change anything below here.


use Mail::Sendmail;


# we make a "fake" message id by taking the current number
# of seconds since the beginning of Unix time and tacking on
# a random number to the end, in case we are called quicker than
# 1 second since the last time we were called.
sub make_message_id
{
	my $date = `date "+\%s"`;
	chomp($date);
	my $pseudo_rand = int (rand(4200));
	$message_id = "<$date$pseudo_rand\@foobar.com>";
	print "new message id = $message_id\n";
}



$cc = "";

sub send_message
{
	%mail = (	To	=>	$to,
			From	=>	$from,
			CC	=>	$cc,
			Subject	=>	$subject,
			Message	=>	$message,
			'Reply-to'	=>	$from,
			'In-Reply-To'	=>	$reply_to,
			'Message-ID'	=>	$message_id,
			'X-Mailer'	=>	"gregkh_patchbomb",
		);

	$mail{smtp} = 'localhost';

	sendmail(%mail) or die $Mail::Sendmail::error;

	print "OK. Log says:\n", $Mail::Sendmail::log;
	print "\n\n"
}


$reply_to = $initial_reply_to;
make_message_id();
$subject = $initial_subject;

foreach $t (@files) {
	$F = $t;
	open F or die "can't open file $t";

	# first line is the CC: list
	$cc = <F>;
	print "cc: $cc";
	
	# second line is the Subject:
	$subject = <F>;
	print "subject: $subject";

	undef $/;
	$message = <F>;	# slurp the whole file in
	close F;
	$/ = "\n";
	send_message();

	# set up for the next message
	$reply_to = $message_id;
	make_message_id();
#	$subject = "Re: ".$initial_subject;
}

