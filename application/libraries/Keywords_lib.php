<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Keywords library generate keywords from text.
 * Returns a lowercase string with keywords ordered by occurance in content seperated with comma's
 * 
 * @author Martijn van Nieuwenhoven info@axyrmedia.nl (original version)
 * @author Michael Kovalskiy (modified version)
 */
class Keywords_lib{
	
	/*private $stop_words = array(
	   'EN' => "a, able, about, above, abst, accordance, according, accordingly, across, act, actually, added, adj, affected, affecting, affects, after, afterwards, again, against, ah, all, almost, alone, along, already, also, although, always, am, among, amongst, an, and, announce, another, any, anybody, anyhow, anymore, anyone, anything, anyway, anyways, anywhere, apparently, approximately, are, aren, arent, arise, around, as, aside, ask, asking, at, auth, available, away, awfully, b, back, be, became, because, become, becomes, becoming, been, before, beforehand, begin, beginning, beginnings, begins, behind, being, believe, below, beside, besides, between, beyond, biol, both, brief, briefly, but, by, c, ca, came, can, cannot, can't, cause, causes, certain, certainly, co, com, come, comes, contain, containing, contains, could, couldnt, d, date, did, didn't, different, do, does, doesn't, doing, done, don't, down, downwards, due, during, e, each, ed, edu, effect, eg, eight, eighty, either, else, elsewhere, end, ending, enough, especially, et, et-al, etc, even, ever, every, everybody, everyone, everything, everywhere, ex, except, f, far, few, ff, fifth, first, five, fix, followed, following, follows, for, former, formerly, forth, found, four, from, further, furthermore, g, gave, get, gets, getting, give, given, gives, giving, go, goes, gone, got, gotten, h, had, happens, hardly, has, hasn't, have, haven't, having, he, hed, hence, her, here, hereafter, hereby, herein, heres, hereupon, hers, herself, hes, hi, hid, him, himself, his, hither, home, how, howbeit, however, hundred, i, id, ie, if, i'll, im, immediate, immediately, importance, important, in, inc, indeed, index, information, instead, into, invention, inward, is, isn't, it, itd, it'll, its, itself, i've, j, just, k, keep, keeps, kept, kg, km, know, known, knows, l, largely, last, lately, later, latter, latterly, least, less, lest, let, lets, like, liked, likely, line, little, 'll, look, looking, looks, ltd, m, made, mainly, make, makes, many, may, maybe, me, mean, means, meantime, meanwhile, merely, mg, might, million, miss, ml, more, moreover, most, mostly, mr, mrs, much, mug, must, my, myself, n, na, name, namely, nay, nd, near, nearly, necessarily, necessary, need, needs, neither, never, nevertheless, new, next, nine, ninety, no, nobody, non, none, nonetheless, noone, nor, normally, nos, not, noted, nothing, now, nowhere, o, obtain, obtained, obviously, of, off, often, oh, ok, okay, old, omitted, on, once, one, ones, only, onto, or, ord, other, others, otherwise, ought, our, ours, ourselves, out, outside, over, overall, owing, own, p, page, pages, part, particular, particularly, past, per, perhaps, placed, please, plus, poorly, possible, possibly, potentially, pp, predominantly, present, previously, primarily, probably, promptly, proud, provides, put, q, que, quickly, quite, qv, r, ran, rather, rd, re, readily, really, recent, recently, ref, refs, regarding, regardless, regards, related, relatively, research, respectively, resulted, resulting, results, right, run, s, said, same, saw, say, saying, says, sec, section, see, seeing, seem, seemed, seeming, seems, seen, self, selves, sent, seven, several, shall, she, shed, she'll, shes, should, shouldn't, show, showed, shown, showns, shows, significant, significantly, similar, similarly, since, six, slightly, so, some, somebody, somehow, someone, somethan, something, sometime, sometimes, somewhat, somewhere, soon, sorry, specifically, specified, specify, specifying, still, stop, strongly, sub, substantially, successfully, such, sufficiently, suggest, sup, sure, t, take, taken, taking, tell, tends, th, than, thank, thanks, thanx, that, that'll, thats, that've, the, their, theirs, them, themselves, then, thence, there, thereafter, thereby, thered, therefore, therein, there'll, thereof, therere, theres, thereto, thereupon, there've, these, they, theyd, they'll, theyre, they've, think, this, those, thou, though, thoughh, thousand, throug, through, throughout, thru, thus, til, tip, to, together, too, took, toward, towards, tried, tries, truly, try, trying, ts, twice, two, u, un, under, unfortunately, unless, unlike, unlikely, until, unto, up, upon, ups, us, use, used, useful, usefully, usefulness, uses, using, usually, v, value, various, 've, very, via, viz, vol, vols, vs, w, want, wants, was, wasn't, way, we, wed, welcome, we'll, went, were, weren't, we've, what, whatever, what'll, whats, when, whence, whenever, where, whereafter, whereas, whereby, wherein, wheres, whereupon, wherever, whether, which, while, whim, whither, who, whod, whoever, whole, who'll, whom, whomever, whos, whose, why, widely, willing, wish, with, within, without, won't, words, world, would, wouldn't, www, x, y, yes, yet, you, youd, you'll, your, youre, yours, yourself, yourselves, you've, z, zero", 
	   'RU' => "а, е, и, ж, м, о, на, не, ни, об, но, он, мне, мои, мож, она, они, оно, мной, много, многочисленное, многочисленная, многочисленные, многочисленный, мною, мой, мог, могут, можно, может, можхо, мор, моя, моё, мочь, над, нее, оба, нам, нем, нами, ними, мимо, немного, одной, одного, менее, однажды, однако, меня, нему, меньше, ней, наверху, него, ниже, мало, надо, один, одиннадцать, одиннадцатый, назад, наиболее, недавно, миллионов, недалеко, между, низко, меля, нельзя, нибудь, непрерывно, наконец, никогда, никуда, нас, наш, нет, нею, неё, них, мира, наша, наше, наши, ничего, начала, нередко, несколько, обычно, опять, около, мы, ну, нх, от, отовсюду, особенно, нужно, очень, отсюда, в, во, вон, вниз, внизу, вокруг, вот, восемнадцать, восемнадцатый, восемь, восьмой, вверх, вам, вами, важное, важная, важные, важный, вдали, везде, ведь, вас, ваш, ваша, ваше, ваши, впрочем, весь, вдруг, вы, все, второй, всем, всеми, времени, время, всему, всего, всегда, всех, всею, всю, вся, всё, всюду, г, год, говорил, говорит, года, году, где, да, ее, за, из, ли, же, им, до, по, ими, под, иногда, довольно, именно, долго, позже, более, должно, пожалуйста, значит, иметь, больше, пока, ему, имя, пор, пора, потом, потому, после, почему, почти, посреди, ей, два, две, двенадцать, двенадцатый, двадцать, двадцатый, двух, его, дел, или, без, день, занят, занята, занято, заняты, действительно, давно, девятнадцать, девятнадцатый, девять, девятый, даже, алло, жизнь, далеко, близко, здесь, дальше, для, лет, зато, даром, первый, перед, затем, зачем, лишь, десять, десятый, ею, её, их, бы, еще, при, был, про, процентов, против, просто, бывает, бывь, если, люди, была, были, было, будем, будет, будете, будешь, прекрасно, буду, будь, будто, будут, ещё, пятнадцать, пятнадцатый, друго, другое, другой, другие, другая, других, есть, пять, быть, лучше, пятый, к, ком, конечно, кому, кого, когда, которой, которого, которая, которые, который, которых, кем, каждое, каждая, каждые, каждый, кажется, как, какой, какая, кто, кроме, куда, кругом, с, т, у, я, та, те, уж, со, то, том, снова, тому, совсем, того, тогда, тоже, собой, тобой, собою, тобою, сначала, только, уметь, тот, тою, хорошо, хотеть, хочешь, хоть, хотя, свое, свои, твой, своей, своего, своих, свою, твоя, твоё, раз, уже, сам, там, тем, чем, сама, сами, теми, само, рано, самом, самому, самой, самого, семнадцать, семнадцатый, самим, самими, самих, саму, семь, чему, раньше, сейчас, чего, сегодня, себе, тебе, сеаой, человек, разве, теперь, себя, тебя, седьмой, спасибо, слишком, так, такое, такой, такие, также, такая, сих, тех, чаще, четвертый, через, часто, шестой, шестнадцать, шестнадцатый, шесть, четыре, четырнадцать, четырнадцатый, сколько, сказал, сказала, сказать, ту, ты, три, эта, эти, что, это, чтоб, этом, этому, этой, этого, чтобы, этот, стал, туда, этим, этими, рядом, тринадцать, тринадцатый, этих, третий, тут, эту, суть, чуть, тысяч",
	   'UA' => "як, для, що, або, це, цих, всіх, вас, вони, воно, ще, коли, де, ця, лише, вже, вам, ні, якщо, треба, все, так, його, чим, при, навіть, мені, є, раз, два",
	   'NL' => "aan, af, al, als, bij, dan, dat, die, dit, een, en, er, had, heb, hem, het, hij, hoe, hun, ik	in, is, je, kan, me, men, met, mij, nog, nu, of, ons, ook, te, tot, uit, van, was	wat, we, wel, wij, zal, ze, zei, zij, zo, zou",
	);*/
    
    /**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		log_message('debug', "Keywords_lib Class Initialized");
	}
    
    /**
	 * Returns a lowercase string with keywords ordered by occurance in content seperated with comma's
	 * 
	 * @param string $string
	 * @param integer $min_word_char
	 * @param integer $keyword_amount
	 * @param string $exclude_words stop words seperated with comma's
	 * @return string
	 */	
	public function generate($string = '', $min_word_char = 4, $keyword_amount = 10,  $exclude_words = '' ) 
	{
		
		$exclude_words = explode(", ", $exclude_words);
		//add space before br tags so words aren't concatenated when tags are stripped
		$string = preg_replace('/\<br(\s*)?\/?\>/i', " ", $string); 
		// get rid off the htmltags
		$string = html_entity_decode(strip_tags($string), ENT_NOQUOTES , 'UTF-8');
		
		// count all words with str_word_count_utf8
		$initial_words_array  = $this->str_word_count_utf8($string, 1);
		
		$new_string = $string;
		
		//convert to lower case
		$new_string = mb_convert_case($new_string, MB_CASE_LOWER, "UTF-8");
		
		// strip excluded words
		foreach($exclude_words as $filter_word)	
		{
			$new_string = preg_replace("/\b".$filter_word."\b/i", "", $new_string); 
		}
		
		// calculate words again without the excluded words using str_word_count_utf8
		$words_array = self::str_word_count_utf8($new_string, 1);
		$words_array = array_filter($words_array, create_function('$var', 'return (mb_strlen($var) >= '.$min_word_char.');'));
		
		$popularity = array();
		$unique_words_array = array_unique($words_array);
		
		// create density array
		foreach($unique_words_array as  $key => $word)	
		{
			preg_match_all('/\b'.$word.'\b/i', $string, $out);
			$count = count($out[0]);	
			$popularity[$key]['count'] = $count;
			$popularity[$key]['word'] = $word;
		}
		
		usort($popularity, array($this,'cmp'));
		
		// sort array form higher to lower
		krsort($popularity);
		//dump($popularity);exit;
		
		// create keyword array with only words
		$keywords = array();
		foreach($popularity as $value)
		{
			$keywords[] = $value['word']; 
		}
					
		// glue keywords to string seperated by comma, maximum 15 words
		$keystring =  implode(', ', array_slice($keywords, 0, $keyword_amount));
		
		// return the keywords
		return $keystring;
	}
	
	/**
	 * Sort array by count value
	 */
	private function cmp($a, $b) 
	{
		return ($a['count'] > $b['count']) ? +1 : -1;
	}

	/** Word count for UTF8
	/* Found in: http://www.php.net/%20str_word_count#85592
	/* The original mask contained the apostrophe, not good for Meta keywords:
	/* "/\p{L}[\p{L}\p{Mn}\p{Pd}'\x{2019}..."
	*/
    private function str_word_count_utf8($string, $format = 0) 
    {
        switch ($format) 
        {
        case 1:
            preg_match_all("/\p{L}[\p{L}\p{Mn}\p{Pd}]*/u", $string, $matches);
            return $matches[0];
        case 2:
            preg_match_all("/\p{L}[\p{L}\p{Mn}\p{Pd}]*/u", $string, $matches, PREG_OFFSET_CAPTURE);
            $result = array();
            foreach ($matches[0] as $match) 
            {
                $result[$match[1]] = $match[0];
            }
            return $result;
        }
        return preg_match_all("/\p{L}[\p{L}\p{Mn}\p{Pd}]*/u", $string, $matches);
    }		
	
}