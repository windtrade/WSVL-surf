
/**
 * Omnipotent bar class
 *
 * @deprecated in version 2.1
 */
class Foo {

    public static void main(String[] arg) {
	Foo bar = new Foo(1);
	System.out.println(bar.println());
    }

    /** May be too low */
    private int bar;
    
    /**
     * Initialize the bar at some point.
     *
     * @param bar The bar parameter.
     */
    public Foo(int bar) {
	this.bar = bar;
    }

    /**
     * Check for high bar
     *
     * This method does nothing if the bar is at an acceptable level.
     *
     * @throws Exception if the bar is too high
     */
    public void highBar() {
	if(bar > 9000)
	    throw new Exception("The bar is too high");
    }

    /**
     * Raise the bar
     *
     * The bar can be to low, and therefore need to be raised. This can be accomplished in some way.
     */
    public int raise() {
	bar++;
    }
}
